<?php

namespace App\Http\Controllers;

use App\Models\Societies;
use Illuminate\Http\Request;

class AuditorController extends Controller
{
    //
    public function dashboard(){
        return view('auditor.dashboard');
    }

    public function store(Request $request){
        $request->validate([
            ''
        ]);
    }

    public function show(){
        $societies = Societies::all();
        return view('auditor.view',compact('societies'));
    }
}
