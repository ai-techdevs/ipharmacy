<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PageDataTable;
use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Traits\UploaderTrait;

class PageController extends Controller
{
    use UploaderTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(PageDataTable $dataTable)
    {
        return $dataTable->render("admin.pages.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'page_name'     => 'required|string|max:255',
            'section_name'  => 'nullable|string|max:255',
            'section_title' => 'nullable|string|max:255',
            'section_text'  => 'nullable|string',
            'description'   => 'nullable|string',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status'        => 'required|in:0,1',
        ], [
            'page_name.required' => 'The Page Name is required.',
            
            'image.image'        => 'The file must be an image.',
            'image.mimes'        => 'Allowed formats: jpeg, png, jpg, gif, webp.',
            'image.max'          => 'Image size must not exceed 2MB.',
            'status.required'    => 'Please select a status.',
            'status.in'          => 'Invalid status option.',
        ]);
        $input = $request->except(['image']);


        $page = Page::create($input);
        if ($request->file('image')) {
            $file = $this->uploadByInterventionImage($request->file('image'), 600, 'pages');
            $page->update(['image' => $file['path']]);
        }

        return redirect(route('admin.pages.index'))->with('success', 'Page is created successfully.');
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
        $page = Page::findOrFail($id);

        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       $input = $request->except(['image']);
      
        $page = Page::findOrFail($id);
          $page->update($input);
        if($request->file('image')){
            if ($page->image && \Storage::disk('public')->exists($page->image)) {
                \Storage::disk('public')->delete($page->image); // Delete the file from storage
            }
           $file = $this->uploadByInterventionImage($request->file('image'), 600, 'pages');
           $page->update(['image' => $file['path']]) ;

        }

        return redirect(route('admin.pages.index'))->with('success', 'Page is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
