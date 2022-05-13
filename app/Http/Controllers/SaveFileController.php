<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataFile;
use File;

class SaveFileController extends Controller
{
    //
    public function index(Request $request)
    {
        # code...
        $list_file = DataFile::all();
        if ($request->ajax()) {
            $list_files = DataFile::all();
            for ($i=0; $i < count($list_files); $i++) { 
                # code...
                $list_files[$i]->passed_time = $list_file[$i]->created_at->diffForHumans();
            }
            // foreach ($list_files as $list_file) {
            //     # code...
            //     $list_file->passed_time = $list_file->created_at->diffForHumans();
            // }
            return response()->json($list_files);
        }
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
        $name = $actual_name.".".$extension;

        $i = 1;
        // while(file_exists("$tujuan_upload/".$actual_name.".".$extension))
        // {           
        //     $actual_name = (string)$original_name."-$i";
        //     $name = $actual_name.".".$extension;
        //     $i++;
        // }
        // dd($name);


        $file_save = new DataFile;
        $file_save->file_name = $name;
        $file_save->status = "pending";
            
        if ($file_save->save()) {
            # code...
            if (file_exists("$tujuan_upload/".$actual_name.".".$extension)) {
                # code...
                File::delete($tujuan_upload.$name);
                $file->move($tujuan_upload,$name);
            }else {
                # code...
                $file->move($tujuan_upload,$name);
            }
            return redirect('/upload')->with('success','Data berhasil diubah'); 
        }
        //         // upload file
	}
}
