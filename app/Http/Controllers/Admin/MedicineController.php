<?php

namespace App\Http\Controllers\Admin;

use App\Models\Medicine;
use App\Traits\HelperTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\MedicineDataTable;

class MedicineController extends Controller
{
    use HelperTrait;

    public function index(MedicineDataTable $dataTable)  {
        return $dataTable->render('admin.medicines.index') ;
    }

    public function create(Request $request)  {
         if (!auth()->user()->role->hasPermission('medicine.create')) {
            abort(403, 'You do not have permission to view this module.');
        }
        return view('admin.medicines.create') ;
    }

    public function edit(Request $request, $id)  {

        $medicine = Medicine::findOrFail($id) ;
        return view('admin.medicines.edit', compact('medicine')) ;
    }

    public function show(Request $request, $id)  {

       
    }

    public function store(Request $request)  {

        $request->validate([
            'name' => 'required|max:255',
            'uses' => 'required',
            'additional_information' => 'required',
            'precautions' => 'required',
            'interactions' => 'required',
            'side_effects' => 'required',
            'pdf'=> 'mimes:pdf|max:5121','pdf2'=> 'mimes:pdf|max:5121','pdf3'=> 'mimes:pdf|max:5121',
        ]);
        $input = $request->except(['pdf','pdf2','pdf3']) ;
        $medicine = Medicine::create($input);
        if(!empty($request->pdf)){
           $file = $this->uploadFile($request->pdf, "medicines") ;
           $medicine->update(['pdf_path' => $file['path']]) ;
        }
         if(!empty($request->pdf2)){
           $file = $this->uploadFile($request->pdf2, "medicines") ;
           $medicine->update(['pdf_path2' => $file['path']]) ;
        } if(!empty($request->pdf3)){
           $file = $this->uploadFile($request->pdf3, "medicines") ;
           $medicine->update(['pdf_path3' => $file['path']]) ;
        }

         return redirect(route('admin.medicines.index'))->with('success', 'Medicne is created successfully.') ;

    }
    public function update(Request $request, $id)  {

        $medicine = Medicine::findOrFail($id) ;

        $request->validate([
            'name' => 'required|max:255',
            'uses' => 'required',
            'additional_information' => 'required',
            'precautions' => 'required',
            'interactions' => 'required',
            'side_effects' => 'required',
            'pdf'=> 'mimes:pdf|max:5121','pdf2'=> 'mimes:pdf|max:5121','pdf3'=> 'mimes:pdf|max:5121',
        ]);

        $input = $request->except(['pdf','pdf2','pdf3']) ;

        $medicine->update($input) ;

        if(!empty($request->pdf)){

            if(is_file(public_path('storage/' . $medicine->pdf_path))){
                unlink(public_path('storage/' . $medicine->pdf_path)) ;
            }

           $file = $this->uploadFile($request->pdf, "medicines") ;
           $medicine->update(['pdf_path' => $file['path']]) ;

        }
         if(!empty($request->pdf2)){

            if(is_file(public_path('storage/' . $medicine->pdf_path2))){
                unlink(public_path('storage/' . $medicine->pdf_path2)) ;
            }

           $file = $this->uploadFile($request->pdf2, "medicines") ;
           $medicine->update(['pdf_path2' => $file['path']]) ;

        }
         if(!empty($request->pdf3)){

            if(is_file(public_path('storage/' . $medicine->pdf_path3))){
                unlink(public_path('storage/' . $medicine->pdf_path3)) ;
            }

           $file = $this->uploadFile($request->pdf3, "medicines") ;
           $medicine->update(['pdf_path3' => $file['path']]) ;

        }

        return redirect(route('admin.medicines.index'))->with('success', 'Medicne is updated successfully.') ;

    }

}
