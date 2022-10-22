<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Http\Requests\FilestoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files = File::all();     
        // Return Json Response
        return response()->json([
           'files' => $files
        ],200);
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
    public function store(FilestoreRequest $request)
    {
        try {
            $file=$request->file('file');  
            $fileName = Str::random(32).".".$file->getClientOriginalExtension();   
            $filesize = $file->getSize();  
            $path= 'storage/'.$fileName;     
            //create file
            File::create([
                'name' => $fileName,
                'size' => $filesize,
                'file' => $path,
            ]);
            // Save Image in Storage folder           
            Storage::disk('public')->put($fileName, file_get_contents($file));
            return response()->json(['messaje'=>'File success created'],200);
        } catch (\Throwable $th) {
            return response()->json(['message' => "Something went really wrong!"],500);
        }       

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Detail 
        $file = File::find($id);
        if(!$file){
          return response()->json([
             'message'=>'File Not Found.'
          ],404);
        }
     
        // Public storage
        $storage = Storage::disk('public');
     
        // Iamge delete
        if($storage->exists($file->file))
            $storage->delete($file->file);
     
        // Delete Product
        $file->delete();
     
        // Return Json Response
        return response()->json([
            'message' => "File successfully deleted."
        ],200);
    }
}
