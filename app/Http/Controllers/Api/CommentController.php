<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
    public function store(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'author_name' => 'required|string|max:255',
                'comment' => 'required|string|max:1000',
            ]);
            Log::info('Validated Data: ', $validated);

            $post = Post::findOrFail($id);
            Log::info('Post Found: ', $post->toArray());

            $comments = $post->comments()->create([
                'author_name' => $validated['author_name'],
                'body'    => $validated['comment'],
                'user_id' => auth()->check() ? auth()->id() : null,
                'post_id' => $id,
            ]);
            Log::info('Comment Created: ', $comments->toArray());

            return response()->json([
                'message' => 'Comment added successfully!',
                'data'    => $comments
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
            
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Post not found'
            ], 404);
            
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create comment',
                'error' => env('APP_DEBUG') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }
}
