<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class AuthController extends Controller
{
    public function index()
    {
        return view("auth.login");
    }

    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6'
        ]);
        
        $user = User::where('email', operator: $request->email)->first();
        if($user) return back()->with('error', 'Email is already taken');
        
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return view('test')->with('success', 'You have successfully registered');
    }


    public function login(Request $request): RedirectResponse {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $user = User::where('email', operator: $request->email)->first();
        if (!$user)  return back()->withErrors([
                'email or password incorrect' => 'The provided credentials do not match our records.',
            ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $token = $user->createToken('auth_token')->plainTextToken;

                return response()->json([
                    'access_token' => $token,
                    'token_type' => 'Bearer'
                ]);
            }
        return redirect()->route('dashboard')->with('success', "Hello $user->name, you have successfully logged in.");
    }

    public function dashboard()
    {
        if(Auth::check()){
            return view('dashboard');
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect("login")->withSuccess('Successfully logged out');
    }
}