<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index($id)
    {
        $comments = Comment::where('post_id', $id)->get();
        // dd($comments);

        return response()->json([
            'comments' => $comments
        ]);
    }

    // Store a comment for a post
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'author_name' => 'required|string|max:255',
            'comment' => 'required|string|max:1000',
        ]);

        $comments = $post->comments()->create([
            'author_name' => $validated['author_name'],
            'body'    => $validated['comment'],
            'user_id' => auth()->id(), // works if user is logged in via API
        ]);

        return response()->json([
            'message' => 'Comment added successfully!',
            'data'    => $comments
        ], 201);
    }
}
