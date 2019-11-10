<?php

namespace App\Http\Controllers\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
    //    dd($request->all());
    $validatedData = $request->validate([
        'name'=> 'required|max:255',
        'email'=>'required|email|max:255',
        'password'=>'required|min:6|confirmed',
    ]);

    if(\App\User::where('email',$request->email)->exists()){
        return redirect()->back();
    }
    $validatedData['password']=Hash::make($validatedData['password']);
    
    \App\User::create($validatedData);

    
    return redirect()->route('login');
//    dd($validatedData);
    }
}
