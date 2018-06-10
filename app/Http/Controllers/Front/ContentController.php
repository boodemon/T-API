<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Content;

class ContentController extends Controller
{
    public function policy(){
        $row = Content::where('content_type','policy')->first();
        $data = [
            'row' => $row,
        ];
        return view('policy',$data);    }
}
