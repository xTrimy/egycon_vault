<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;



use Illuminate\Http\Request;

class UserController extends Controller
{
    public function add()
    {
        return view('add-user');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required||min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        auth()->attempt($request->only('email', 'password'));
        return redirect()->back()->with('success', 'User created successfully.');

    }
}
