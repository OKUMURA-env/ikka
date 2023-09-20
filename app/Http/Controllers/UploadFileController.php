<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadFileController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // dd($request->file->getClientOriginalName());
        if($request->file){
        $file_name = $request->file->getClientOriginalName();
        $request->file->storeAs('public/', $file_name);

        return '/storage/'.$file_name;
        }
    }
}
