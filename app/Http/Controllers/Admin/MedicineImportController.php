<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medicine;
use Illuminate\Support\Str;

class MedicineImportController extends Controller
{
    public function showForm()
    {
        return view('admin.medicines.import');
    }

    function generateUniqueSlug($name) {
   
    $slug = Str::slug($name);

    
    $count = 0;
    $originalSlug = $slug;

    while (Medicine::where('slug', $slug)->exists()) {
        $count++;
        $slug = $originalSlug . '-' . $count;
    }

    return $slug;
}


    public function importCsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');

        // Open the CSV file
        if (($handle = fopen($file->getRealPath(), 'r')) !== false) {

            $header = fgetcsv($handle, 1000, ',');
            $header = array_map(function ($h) {
              
                $h = preg_replace('/^\x{FEFF}/u', '', $h);
                return strtolower(trim($h));
            }, $header);

            $titleIndex = array_search('title', $header);

            if ($titleIndex === false) {
                return back()->with('error', 'CSV does not have a "title" column.');
            }

            $dataToInsert = [];

            while (($row = fgetcsv($handle, 1000, ',')) !== false) {

                $name = $row[$titleIndex];
                if (!$name) continue;

                $dataToInsert[] = [
                    'name' => $name,
                    'slug' => $this->generateUniqueSlug($name),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            fclose($handle);


            foreach (array_chunk($dataToInsert, 500) as $chunk) {
                Medicine::insert($chunk);
            }

            return back()->with('success', 'Medicines imported successfully!');
        }

        return back()->with('error', 'Could not read the CSV file.');
    }
}
