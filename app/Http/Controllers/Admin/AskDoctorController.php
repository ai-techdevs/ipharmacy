<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\AskDoctorDataTable;

class AskDoctorController extends Controller
{
    public function index(AskDoctorDataTable $dataTable) {


        return $dataTable->render('admin.ask-doctors.index') ;
    }
}
