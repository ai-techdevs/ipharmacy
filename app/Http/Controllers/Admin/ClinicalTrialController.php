<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\AskDoctorDataTable;
use App\DataTables\ClinicalTrialDataTable;
use App\Models\ClinicalTrial;

class ClinicalTrialController extends Controller
{
    public function index(ClinicalTrialDataTable $dataTable) {
        return $dataTable->render('admin.clinical-trials.index') ;
    }

     public function edit(string $id)
    {
        $trail = ClinicalTrial::findOrFail($id) ;

// dd( $trail);

        return view('admin.clinical-trials.edit')->with([
            'trail' => $trail,
        ]);
    }
}
