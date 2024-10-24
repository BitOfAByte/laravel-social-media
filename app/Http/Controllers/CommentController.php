<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostComments;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    public function index($postId)
    {
        $post = Post::with('comments')->findOrFail($postId);
        return view('comments.index', compact('post'));
    }

    /**
     * Store a newly created comment in storage.
     */
    public function store(Request $request, $postId)
    {
        $request->validate([
            'comment' => 'required|string|max:255',
        ]);

        $post = Post::find($postId);
        if (!$post) {
            return response()->json(['message' => 'Post not found.'], 404);
        }

        PostComments::create([
            'post_id' => $postId,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
        ]);

        return response()->json(['message' => 'Comment added successfully.']);
    }

    /**
     * Update the specified comment in storage.
     */
    public function update(Request $request, $commentId)
    {
        $request->validate([
            'comment' => 'required|string|max:255',
        ]);

        $comment = PostComments::find($commentId);
        if (!$comment) {
            return response()->json(['message' => 'Comment not found.'], 404);
        }

        if ($comment->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $comment->update([
            'comment' => $request->comment,
        ]);

        return response()->json(['message' => 'Comment updated successfully.']);
    }

    /**
     * Remove the specified comment from storage.
     */
    public function destroy($commentId)
    {
        $comment = PostComments::find($commentId);
        if (!$comment) {
            return response()->json(['message' => 'Comment not found.'], 404);
        }

        if ($comment->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully.']);
    }
}
