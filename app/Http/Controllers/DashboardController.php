<?php

namespace App\Http\Controllers;

use App\Models\Avatar;
use App\Models\Belonging;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    
    public function index(){
        $belongings_in = Belonging::where('status',1)->get();
        $belongings_out = Belonging::where('status',0)->get();
        $belongings = Belonging::with('size')->with('type')->paginate(15);
        $belongings->count_in = count($belongings_in);
        $belongings->count_out = count($belongings_out);
        $belongings->count = count($belongings_in) + count($belongings_out);
        return view('home', ['belongings' => $belongings]);
    }
}
