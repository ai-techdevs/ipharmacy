<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Traits\UploaderTrait;
use App\Http\Controllers\Controller;
use App\DataTables\WorkingPartnerDataTable;
use App\Http\Requests\Admin\WorkingPartner\CreateWorkingPartnerRequest;

class WorkingPartnerController extends Controller
{
    use UploaderTrait;

    public function index(WorkingPartnerDataTable $dataTable)  {
        return $dataTable->render('admin.working-partners.index') ;
    }

    public function create()  {
        return view('admin.working-partners.create') ;
    }

    public function store(CreateWorkingPartnerRequest $request)  {

        if(!empty($request->image)){
           $file = $this->uploadFile($request->file('image'), "partners") ;
           $banner = Banner::create([
                        'name' => $request->name,
                        'path'=> $file['path'],
                        'banner_type'=> 'working-partner',
                        'page_name' => 'home',
                    ]) ;

         return redirect()->route('admin.working-partners.index')->with('success', 'Image is saved succesfully');
        }
    }

    public function destroy($id)  {

        $banner = Banner::findOrFail($id);

        if($banner->path){
            unlink(public_path('storage/'. $banner->path)) ;
        }

        $banner->delete() ;

        return redirect(route('admin.working-partners.index'));

    }

    // public function update(CreateWorkingPartnerRequest $request)  {

    //     if(!empty($request->image)){
    //        $file = $this->uploadFile($request->file('image'), "partners") ;
    //        $banner = Banner::create([
    //                     'name' => $request->name,
    //                     'path'=> $file['path'],
    //                     'banner_type'=> 'working-partner',
    //                     'page_name' => 'home',
    //                 ]) ;

    //      return redirect()->route('admin.working-partners.index')->with('success', 'Image is saved succesfully');
    //     }
    // }
}
