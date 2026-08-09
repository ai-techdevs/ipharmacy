<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;



trait HelperTrait{

    public $basePath = 'uploads/';

    // Upload File In Public Path.
      public function uploadFile($file, $folder = "")
        {

            $filename = $this->getUniqueId() . "." . $file->getClientOriginalExtension();
            \Storage::disk('public')->putFileAs($folder, $file, $filename);

            return ['fileName'=> $filename, "path" => $folder."/".$filename] ;

        }


     public function getUniqueId()
     {
         return md5(microtime().\Config::get('app.key'));
     }




     public function base64UploadImage($file, $path)
     {
         $folderPath = storage_path() . '/'. $path;

         File::isDirectory($folderPath) or File::makeDirectory($folderPath, 0777, true, true);

         // $image = str_replace('data:image/png;base64,', '', $file);
         $image = preg_replace('#^data:image/\w+;base64,#i', '', $file);
         $image = str_replace(' ', '+', $image);

         $imageName = $this->getUniqueId() . '.jpg';

         //$success = file_put_contents(storage_path().'/'.$path.'/'.$imageName, base64_decode($image));
         Storage::disk('public')->put($path.'/'.$imageName, base64_decode($image));


         return ['fileName'=> $imageName, 'path'=> $path.'/'.$imageName] ;

     }

     public function base64UploadPdf($file, $path)
     {
         $folderPath = storage_path() . '/'. $path;

         File::isDirectory($folderPath) or File::makeDirectory($folderPath, 0777, true, true);

         $file = str_replace('data:application/pdf;base64,', '', $file);
         //    // $image = preg_replace('#^data:image/\w+;base64,#i', '', $file);
         //     $image = str_replace(' ', '+', $image);

         $fileName = $this->getUniqueId() . '.pdf';

         //$success = file_put_contents(storage_path().'/'.$path.'/'.$imageName, base64_decode($image));
         Storage::disk('public')->put($path.'/'.$fileName, base64_decode($file));


         return ['fileName'=> $fileName, 'path'=> $path.'/'.$fileName] ;

     }

}
