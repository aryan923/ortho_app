<?php

namespace App\Http\Controllers;

use App\Models\role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

public function register(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'Contact_Number' => 'required|string|max:20|unique:users,Contact_Number',
            'address' => 'required|string|max:255',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'Contact_Number' => $validated['Contact_Number'],
            'address' => $validated['address'],
            
        ]);

        $userRole = role::where('name', 'user')->first();

        $user->roles()->attach($userRole->id); // Assign the 'user' role to the newly registered user

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'User created successfully.',
                'user' => $user,
            ], 201);
        }

        return redirect()->route('login')->with('success', 'Registration successful. Please log in.');

    }

    public function viewRegister(){
        return view('Auth.register');
    }
    
public function login(Request $request){

    $validated = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    

    if(Auth::attempt($validated, $request->boolean('remember'))){
        $request->session()->regenerate();
        return redirect()->intended('/')->with('success', 'Login successful.');
    
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');

   
 }
    public function viewLogin(){
        return view('Auth.login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'You have been logged out.');
    }
}

