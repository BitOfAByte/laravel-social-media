<?php

namespace App\Http\Controllers;
use App\Models\Post;
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
        return view('users.profile', compact('user' ));
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


    public function edit($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('users.index')->with('error', 'User not found.');
        }

        return view('users.edit', compact('user'));
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
        'bio' => 'nullable|string|max:255', // Corrected validation rule
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

    if ($request->filled('bio')) {
        $user->bio = $request->bio;
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



    public function follow($id)
{
    $userToFollow = User::find($id);

    if (!$userToFollow) {
        return redirect()->route('home')->with('error', 'User not found.');
    }

    $user = auth()->user();
    $user->follows()->attach($userToFollow->id);

    return redirect()->route('user.profile', $userToFollow->username)->with('success', 'User followed successfully.');

}
}
