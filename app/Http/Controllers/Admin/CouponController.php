<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CouponDataTable;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CouponDataTable $dataTable)
    {
         return $dataTable->render("admin.coupon.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      
        return view('admin.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    //dd($request->all());
    $validated = $request->validate([
        'discount'     => 'required|string|max:50',
        'title'        => 'required|string|max:255',
        'description'  => 'required|string',
        'button_text'  => 'nullable|string|max:100',
        'button_link'  => 'nullable|url|max:255',
        'status'       => 'required|boolean',
        'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', 
         'image2'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', 
    ]);

    
    if ($request->hasFile('image')) {
        $validated['image'] = $request->file('image')->store('coupons', 'public');
    }

    if ($request->hasFile('image2')) {
        $validated['image2'] = $request->file('image2')->store('coupons', 'public');
    }

    $coupon = Coupon::create($validated);

    
    return redirect()->route('admin.coupon.index')
                     ->with('success', 'Coupon created successfully!');
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
         $coupon = Coupon::findOrFail($id) ;

          return view('admin.coupon.edit',['coupon'=> $coupon]);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    
    $coupon = Coupon::findOrFail($id);

    
    $validated = $request->validate([
        'discount'     => 'required|string|max:50',
        'title'        => 'required|string|max:255',
        'description'  => 'required|string',
        'button_text'  => 'nullable|string|max:100',
        'button_link'  => 'nullable|url|max:255',
        'status'       => 'required|boolean',
        'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
         'image2'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

   
    if ($request->hasFile('image')) {
      
        if ($coupon->image && file_exists(storage_path('app/public/' . $coupon->image))) {
            unlink(storage_path('app/public/' . $coupon->image));
        }

       
        $validated['image'] = $request->file('image')->store('coupons', 'public');
    }
    if ($request->hasFile('image2')) {
      
        if ($coupon->image2 && file_exists(storage_path('app/public/' . $coupon->image2))) {
            unlink(storage_path('app/public/' . $coupon->image2));
        }

       
        $validated['image2'] = $request->file('image2')->store('coupons', 'public');
    }
 
    $coupon->update($validated);

    
    return redirect()->route('admin.coupon.index')
                     ->with('success', 'Coupon updated successfully!');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
