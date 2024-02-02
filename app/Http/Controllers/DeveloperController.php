<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DeveloperController extends Controller
{
    //
    public function dashboard()
    {
        return view('developer.dashboard');
    }


}
