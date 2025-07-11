<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('religion','caste')->where('id','!=',1)->get();
        // dd($users);
        return view('user.index',compact('users'));
    }

    public function edit($id)
    {
        $religion = User::findOrFail($id);
        return view('user.edit', compact('user'));
    }
    
}
