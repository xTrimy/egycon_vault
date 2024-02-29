<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\BelongingHistory;



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
      //add action to history
      BelongingHistory::create([
        'user_id' => auth()->id(),
        'item_id' => NULL,
        'action_type' => 'User Added',
        'action_date' => now(),
        'description' => 'Added :'.$request->name,
      ]);

    return redirect()->back()->with('success', 'User created successfully.');
  }
}
