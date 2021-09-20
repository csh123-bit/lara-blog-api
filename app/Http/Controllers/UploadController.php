<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function upload(Request $request){
        $file = $request->file('file');

        $dir=date('Ym');
        $path = $file->store('uploads/'.$dir,'public');

        return response()->json(["path"=>$path]);
    }
}
