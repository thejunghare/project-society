<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuditorController extends Controller
{
    //
    public function dashboard(){
        return view('auditor.dashboard');
    }
}
