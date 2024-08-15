<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UploadController extends Controller
{
    function upload(Request $request) {
        $request->pid;
        $file = $request->file('photo');
        $bindata = file_get_contents($file);

        $count = DB::update('update pet_info SET pet_headphoto = ? WHERE pid = ?', [$bindata, $request->pid]);

        if($count) {
            return "OK";
        } else {
            return "NO";

        }
    }
}
