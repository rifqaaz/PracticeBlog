<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'comment' => 'required|string|max:1000',
        ]);
        
        $post->comments()->create([
            'body'    => $validated['comment'],
            'user_id' => auth()->id(), // logged-in user
        ]);

        return back()->with('success', 'Your comment was added!');
    }

    public function create()
    {
        //
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return back()->with('success', 'Comment deleted successfully.');
    }
}
