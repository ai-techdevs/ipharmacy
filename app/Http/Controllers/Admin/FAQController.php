<?php

namespace App\Http\Controllers\Admin;

use App\Models\Faq;
use Illuminate\Http\Request;
use App\DataTables\FAQDataTable;
use App\Http\Controllers\Controller;

class FAQController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, FAQDataTable $dataTable)
    {
        return $dataTable->render("admin.faqs.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view("admin.faqs.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ]);

        $faq = Faq::create($request->all());

        return redirect(route("admin.faqs.index"))->with('success', 'FAQ is created successfully');
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
        $faq = Faq::findOrFail($id) ;



        return view('admin.faqs.edit')->with([
            'faq' => $faq,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ]);

        $faq = Faq::findOrFail($id) ;
        try {

            $faq = $faq->update($request->all());
            return redirect(route("admin.faqs.index"))->with('success', 'FAQ is updated successfully');

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
