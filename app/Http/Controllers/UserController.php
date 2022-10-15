<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Show Register/Create Form
    public function create(){
        return view('users.register');
    }
    // Create new User
    public function store(Request $request){
        $formFields = $request->validate([
            'name'=> ['required', 'min:3'],
            'email'=> ['required', 'email', Rule::unique('users','email')],
            'password'=>'required | confirmed | min:6'          
        ]);
        // hash Password
        $formFields['password']= bcrypt($formFields['password']);
        // Create user
        $user = User::create($formFields);
        //login
        auth()->login($user);

        return redirect('/')->with('message', 'User is created and logged in successfully!');
    }
    // logout
    public function logout(Request $request){
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerate();
        return redirect('/')->with('message', 'You are logut now!');
    }
    // show login form
    public function login(){
        return view('users.login');
    }

    // authenicate user
    public function authenticate(Request $request){
        $formFields = $request->validate([
            'email'=> ['required', 'email'],
            'password'=>'required'          
        ]);
        if(auth()->attempt($formFields)){
            $request->session()->regenerate();
            return redirect('/')->with('message', 'You are now loged in!');
        }
        return back()->withErrors(['email'=>'Invalid Credentials'])->onlyInput('email');
    }
}
