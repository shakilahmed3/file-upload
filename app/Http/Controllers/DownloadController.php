<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DownloadController extends Controller
{
    function onDownload($FolderPath,$name){
        return Storage::download($FolderPath."/".$name);
     }


    function onSelectFileList(){
        $result = DB::table('myFile')->get();
        return $result;
    }
}
