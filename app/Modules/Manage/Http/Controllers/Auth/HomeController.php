<?php

namespace App\Modules\Manage\Http\Controllers\Auth;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Yuansir\Toastr\Facades\Toastr;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //略
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ret = Toastr::error('你好啊','标题');

        return view('vendor.toastr.toastr');
    }
}
