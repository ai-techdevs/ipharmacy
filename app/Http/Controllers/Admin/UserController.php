<?php

namespace App\Http\Controllers\Admin;

use App\Models\Menu;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\UserUpdateRequest;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('admin.users.index');
    }

    public function create(Request $request)
    {
        $menus = Menu::with('permissions')->get();
        $roles = Role::orderByDesc('name')->where('id', '<>', Role::ADMIN)->get();

        return view('admin.users.create', compact('menus', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string|max:255',
            'role_id' => 'required',
            'status' => 'required',
        ]);

        $userInput = [
            "name" => $request->name,
            "email" => $request->email,
            "password" => \Hash::make($request->password),
            "role_id" => $request->role_id,
            "status" => $request->status,
        ];
        $newCreatedUser = User::create($userInput);


        return redirect(route("admin.users.index"))->with('success', 'User is created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $roles = Role::orderByDesc('name')->where('id', '<>', Role::ADMIN)->get();

        return view('admin.users.edit')->with([
            'roles' => $roles,
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(UserUpdateRequest $request, string $id)
    // {
    //     $user  = User::findOrFail($id);
    //     $input = $request->except(['email']);
    //     if ($request->hasFile('image')) {

    //         if ($user->image && Storage::exists('public/' . $user->image)) {
    //             Storage::delete('public/' . $user->image);
    //         }

    //         $path = $request->file('image')->store('profile-images', 'public');
    //         $user->image = $path;
    //     }
    //     if (!empty($request->password)) {
    //         $input['password'] = \Hash::make($request->password);
    //     } else {
    //         unset($input['password']);
    //     }

    //     $user->update($input);

    //     return redirect()
    //         ->route('admin.users.index')
    //         ->with('success', 'User is updated successfully.');
    // }

   public function update(UserUpdateRequest $request, string $id)
{
    $user  = User::findOrFail($id);
    $input = $request->except(['email', 'password']); 

    if ($request->hasFile('image')) {
        if ($user->image && Storage::disk('public')->exists($user->image)) {
            Storage::disk('public')->delete($user->image);
        }
        $path = $request->file('image')->store('profile-images', 'public');
        $input['image'] = $path;
    }

    if ($request->filled('password')) {
        $input['password'] = \Hash::make($request->password);
    }
// dd($input);
    $user->update($input);

    return redirect()
        ->route('admin.users.index')
        ->with('success', 'User is updated successfully.');
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function getRolePermissions($roleId)
    {
        $permissions = \DB::table('role_has_permissions')
            ->where('role_id', $roleId)
            ->pluck('permission_id'); // Fetch only permission IDs

        return response()->json(['permissions' => $permissions]);
    }
}
