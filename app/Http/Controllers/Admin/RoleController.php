<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\RoleDataTable;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Role;
use App\Models\RoleHasPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, RoleDataTable $dataTable)
    {
        return $dataTable->render("admin.roles.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menus = Menu::with('permissions')->get();
        return view("admin.roles.create")->with([
            'role' => "",
            'menus' => $menus,
            'roleHasPermission' => []
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        DB::beginTransaction();
        $roleInput = [
            "name" => $request->name,
            "display_name" => $request->display_name,
        ];
        $newCreatedRole = Role::create($roleInput);

        if(!empty($request->permissions)){
            foreach($request->permissions as $permission)
            {

                $ob= new RoleHasPermission();
                $ob->role_id = $newCreatedRole->id;
                $ob->permission_id = $permission;
                $ob->save();
            }
        }


        DB::commit();

        return redirect(route("admin.roles.index"))->with('success', 'Role with permission created successfully');
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
        $role = Role::find($id);
        $menus = Menu::with('permissions')->get();
       // return $menus;

        $roleHasPermission = RoleHasPermission::where('role_id',$id)->pluck('permission_id')->toArray();
        if (empty($role)) {
            return redirect(route("admin.roles.index"))->with('error', 'Role not found!');


        }


        return view('admin.roles.edit')->with([
            'role' => $role,
            'menus' => $menus,
            'roleHasPermission' => $roleHasPermission
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();
            $role = Role::find($id);

            if (empty($role)) {
                return redirect(route("admin.roles.index"))->with('error', 'Role not found!');

            }



            $roleInput = [
                "name" => $request->name,
                "display_name" => $request->display_name,

            ];

            $user = $role->update($roleInput);
            DB::commit();
            $roleHasPermission = RoleHasPermission::where('role_id',$id)->pluck('permission_id')->toArray();
            if($request->permissions!="")
            {
                //delete
                foreach($roleHasPermission as $val)
                {
                    if(!in_array($val,$request->permissions))
                    {
                        $ob = RoleHasPermission::where([
                            'role_id'=> $id,
                            'permission_id' => $val
                        ])->first();
                        $ob->delete();
                    }
                }
                //insert
                foreach($request->permissions as $permission)
                {
                    if(!in_array($permission,$roleHasPermission))
                    {
                        $ob= new RoleHasPermission();
                        $ob->role_id = $id;
                        $ob->permission_id = $permission;
                        $ob->save();
                    }
                }


            }else{
                return redirect(route("admin.roles.index"))->with('error', 'Atleast one permission required!');
            }
            return redirect(route("admin.roles.index"))->with('success', 'Role with permission updated successfully');
        }
        catch (\Exception $e) {
            DB::rollback();
            return redirect(route("admin.roles.index"))->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
