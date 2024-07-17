<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class SocietiesController extends Controller
{
    function index(){
        $societies = DB::table('societies')->paginate(5);
        return view('societies', ['societies' => $societies]);
    }
}
