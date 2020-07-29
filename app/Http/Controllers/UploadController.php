<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UploadController extends Controller
{

    function onFileUP(Request $request)
    {
      $path =  $request->file('fileKey')->store('images');
      $confirm = DB::table('myfile')->insert(['filePath'=>$path]);

       if($confirm==true){
           return 1;
       }else{
           return 0;
       }
    }
}
