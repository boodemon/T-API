<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(){
        $data = [
            '_breadcrumb'	=> 'Dashboard'
        ];
        return view('backend.dashboard.index',$data);
    }
    //
}
