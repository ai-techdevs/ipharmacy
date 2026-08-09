<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CdcCommentDataTable;
use App\Models\Cdc;
use Illuminate\Http\Request;
use App\Traits\UploaderTrait;
use App\DataTables\CDCDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CDCCreateRequest;

class CdcController extends Controller
{
    use UploaderTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(CDCDataTable $dataTable)
    {
        return $dataTable->render("admin.cdc.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $relatedBlogs = Cdc::
                       where('status', 1)
                       ->get();
                       $selectedRelated = [];
        return view('admin.cdc.create',compact('relatedBlogs','selectedRelated'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CDCCreateRequest $request)
    {
       $input = $request->except(['image']);
        if (!empty($request->related_blogs_ids)) {
        $input['related_blogs_ids'] = implode(',', $request->related_blogs_ids);
    } else {
        $input['related_blogs_ids'] = null;
    }

        $cdc = Cdc::create($input);
        if($request->file('image')){
           $file = $this->uploadByInterventionImage($request->file('image'), 600, 'cdcs');
           $cdc->update(['image' => $file['path']]) ;

        }

        return redirect(route('admin.cdcs.index'))->with('success', 'CDC is created successfully.');

    }

    /**
     * Display the specified resource.
     */
     public function show($id, CdcCommentDataTable $dataTable){
        $cdc = Cdc::findOrFail($id) ;

        return $dataTable->with('cdc_id', $id)->render('admin.cdc.show', ['cdc'=> $cdc]);
        // return view('admin.forums.show', compact('forum')) ;

     }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       $cdc = Cdc::findOrFail($id);
     $relatedBlogs = Cdc::where('id', '!=', $cdc->id)->get();

$selectedRelated = [];

if (!empty($cdc->related_blogs_ids)) {
    if (is_array($cdc->related_blogs_ids)) {
        $selectedRelated = $cdc->related_blogs_ids;
    } else {
        $selectedRelated = explode(',', $cdc->related_blogs_ids);
    }
}
       return view('admin.cdc.edit',compact('cdc','relatedBlogs','selectedRelated')) ;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       
      $input = $request->except(['image']);
      if (!empty($request->related_blogs_ids)) {
        $input['related_blogs_ids'] = implode(',', $request->related_blogs_ids);
    } else {
        $input['related_blogs_ids'] = null;
    }
 //dd($input['related_blogs_ids']);
        $cdc = Cdc::findOrFail($id);
          $cdc->update($input);
        if($request->file('image')){
            if ($cdc->image && \Storage::disk('public')->exists($cdc->image)) {
                \Storage::disk('public')->delete($cdc->image); // Delete the file from storage
            }
           $file = $this->uploadByInterventionImage($request->file('image'), 600, 'cdcs');
           $cdc->update(['image' => $file['path']]) ;

        }

        return redirect(route('admin.cdcs.index'))->with('success', 'CDC is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
