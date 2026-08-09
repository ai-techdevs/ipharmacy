<?php

namespace App\Http\Controllers\Admin;

use App\Models\Menu;
use App\Models\Setting;
use Laracasts\Flash\Flash;
use App\Traits\HelperTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    use HelperTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
       // \Helper::checkIsUserAuthorizeToPerformTheTask('setting.index');

        $setting = Setting::orderBy('id')->get();
        return view('admin.settings.index')->with('settings', $setting);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       // \Helper::checkIsUserAuthorizeToPerformTheTask('setting.update');

        $setting=Setting::where('id',$id)->get()->first();
        //return $setting;
        return view('admin.settings.edit')->with('setting',$setting);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       // \Helper::checkIsUserAuthorizeToPerformTheTask('setting.update');

        
        $setting=Setting::findOrFail($id);
        //dd($setting);
        if($request->fileType == "file"){

            $request->validate([
                'image' => 'required',
            ]);

            if($request->has('image'))
            {
    
                if(is_file(public_path('storage/'.$setting->value)))
                {
                    unlink(public_path('storage/'.$setting->value)) ;
                }
            
                $media = $this->uploadFile($request->file('image'), 'settings');
                $setting->update(['value' => $media['path']]) ;
            }
           
        }else{
            $request->validate([
                'value' => 'required',
            ]);


            $setting->update($request->all());
        }
       
        
        return redirect(route('admin.settings.index'))->with('success', 'Setting Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


}
