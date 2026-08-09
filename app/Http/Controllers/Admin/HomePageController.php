<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomePageController extends Controller
{
    public function index(){
        $datas = Page::where('page_name', 'home')->orderBy('id', 'DESC')->get();
        return view('admin.home.index', compact('datas'));
    }

    public function edit($id){
        $data = Page::findOrFail($id);
        return view('admin.home.edit', compact('data'));
    }

    public function update(Request $request, $id){
        $page = Page::findOrFail($id);
        $page->update($request->all());

        return redirect(route('admin.home-page.index'))->with('success', 'Section is updated successfuly');

    }
}
