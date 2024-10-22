<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function profile($username) {
        $user = User::where('username', $username)->firstOrFail();
        return view('users.profile', compact('user'));
    }

    public function show($id)
    {
        $user = User::query();
        return view('users.show', compact('user'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {

    }

    public function edit($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('users.index')->with('error', 'User not found.');
        }

        return view('home', compact('user'));
    }


    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('home')->with('error', 'User not found.');
        }

        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->filled('email')) {
            $user->email = $request->email;
        }

        if ($request->filled('username')) {
            $user->username = $request->username;
        }

        $user->save();

        return redirect()->route('home')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();
            return redirect()->route('home')->with('success', 'User deleted successfully.');
        }

        return redirect()->route('home')->with('error', 'User not found.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $users = User::where('username', 'LIKE', "%{$query}%")->get();

        return view('search', compact('users'));
    }
}
