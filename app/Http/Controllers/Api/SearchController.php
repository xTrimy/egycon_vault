<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Belonging;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request){
        if(!$request->has('q')){
            return ["error"=>"No query sent"];
        }
        $persons = Belonging::where('name','LIKE',"%{$request->q}%")->with('type')->with('size')->limit(5)->get();
        $colors = Belonging::where('color_name', 'LIKE', "%{$request->q}%")->with('type')->with('size')->limit(5)->get();
        $phone = Belonging::where('phone', 'LIKE', "%{$request->q}%")->with('type')->with('size')->limit(5)->get();
        $email = Belonging::where('email', 'LIKE', "%{$request->q}%")->with('type')->with('size')->limit(5)->get();
        $code = Belonging::where('code', 'LIKE', "%{$request->q}%")->with('type')->with('size')->limit(5)->get();
        return ["name"=>$persons,"color"=>$colors,'phone'=>$phone, 'email' => $email,'code'=>$code];
    }
}
