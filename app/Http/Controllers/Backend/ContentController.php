<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Content;

class ContentController extends Controller
{
    public function aboutus(){
        $row = Content::where('content_type','aboutus')->first();
        $data = [
            'row' => $row,
            '_breadcrumb'	=> 'About Us',
            'action'        => 'content/action-save',
            'content_type'  => 'aboutus',
            'subject'       => 'About Us'
        ];
        return view('backend.contents.from',$data);
    }
    public function policy(){
        $row = Content::where('content_type','policy')->first();
        $data = [
            'row' => $row,
            '_breadcrumb'	=> 'Privacy Policy',
            'action'        => 'content/action-save',
            'content_type'  => 'policy',
            'subject'       => 'Privacy Policy'
        ];
        return view('backend.contents.from',$data);
    }
    public function save(Request $request){
        $type = $request->input('content_type');
        $chk = Content::where('content_type',$type)->first();
        $row = $chk ? $chk : new Content;
        $row->subject   = $request->input('subject');
        $row->detail    = $request->input('detail');
        $row->content_type = $type;
        $row->save();
        return redirect()->back();
    }
}
