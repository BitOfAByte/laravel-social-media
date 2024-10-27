<?php

namespace App\Http\Controllers;

use App\Models\PostSave;
use Illuminate\Http\Request;

class PostSaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $postSaves = PostSave::all();
        return view('post_saves', compact('postSaves'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $postId)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
    ]);

    $postSave = PostSave::firstOrCreate([
        'user_id' => $request->user_id,
        'post_id' => $postId,
    ]);

    return response()->json($postSave, 201);
}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $postSave = PostSave::findOrFail($id);
        return response()->json($postSave);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $postSave = PostSave::findOrFail($id);
        $postSave->delete();
        return response()->json(null, 204);
    }
}
