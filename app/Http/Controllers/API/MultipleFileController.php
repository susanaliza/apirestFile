<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\File; //add File Model
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class MultipleFileController extends Controller
{
    public function uploadFile(Request $request){

        // dd($request->all());
        if($request->has('file')) {
            $file=$request->file;
             foreach ($file as $key=>$value) { 
                $fileName = Str::random(32).".".$value->getClientOriginalExtension(); 
                $filesize = $value->getSize();
                $path= 'storage/'.$fileName; 
                File::create([
                    'name' => $fileName,
                    'size' => $filesize,
                    'file' => $path,
                ]);
                Storage::disk('public')->put($fileName, file_get_contents($value));
                
             }   
             return response()->json(['messaje'=>'file upload success'], 200); 

        }

    }
    
       
    
}
