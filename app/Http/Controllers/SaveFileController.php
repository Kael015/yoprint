<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;

class SaveFileController extends Controller
{
    //
    public function index()
    {
        # code...
        $list_file = File::all();
        return view(
            'upload',[
            'list_file'=>$list_file,
        ]);
    }
    public function proses(Request $request){
        // dd($request);
        
		$file = $request->file('import');
        $name = str_replace(" ", "-", $file->getClientOriginalName());
        $file_name = pathinfo($name, PATHINFO_FILENAME);
        // dd($file_name);
        // $name = $name."-1";
        $tujuan_upload = 'data_file';
        
        
		$type = $file->getClientOriginalExtension();
        $actual_name = pathinfo($name,PATHINFO_FILENAME);
        $original_name = $actual_name;
        $extension = pathinfo($name, PATHINFO_EXTENSION);

        $i = 1;
        while(file_exists("$tujuan_upload/".$actual_name.".".$extension))
        {           
            $actual_name = (string)$original_name."-$i";
            $name = $actual_name.".".$extension;
            $i++;
        }
        // dd($name);


        $file_save = new File;
        $file_save->file_name = $name;
        $file_save->status = "pending";
            
        if ($file_save->save()) {
            # code...
            $file->move($tujuan_upload,$name);
            return redirect('/upload')->with('success','Data berhasil diubah'); 
        }
        //         // upload file
	}
}
