<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountantController extends Controller
{
    //
    public function __construct(){
        $this->middleware("auth");
    }
    public function dashboard()
    {
        return view('accountant.dashboard');
    }

}
