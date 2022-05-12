<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use App\Imports\ProductImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Jobs\ImportFile;

class ProductController extends Controller
{
    //
    public function import() 
    {
        // dispatch(new App\Jobs\ImportFile);
        $data_file = File::where('status', 'pending')->limit(1)->get();
        $file_name = $data_file[0]->file_name;
        // Excel::import(new ProductImport, $file_name, 'data_file');
        if ($data_file) {
            # code...
            $file_name = $data_file[0]->file_name;
            $file_id = $data_file[0]->id;
            dispatch(new ImportFile("$file_name"));
    
            // dispatch(new App\Jobs\ImportFile($file_id));
        }
        dd($file_name);

        // return redirect('/upload')->with('success', 'All good!');
    }
}
