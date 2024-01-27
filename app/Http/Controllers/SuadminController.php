<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuadminController extends Controller
{
    //
    public function dashboard(){
        return view('suadmin.dashboard');
      }
}
