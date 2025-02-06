<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Comment::with('user')->simplePaginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'post_id' => 'required|integer',
            'body' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(), 
                400
            );
        }

        if(!Post::where('id', $request->post_id)->exists()) {
            return response()->json([
                'message' => 'Post not found'
            ], 404);
        }

        $comment = Comment::create([
            'post_id' => $request->post_id,
            'body' => $request->body,
            'user_id' => $request->user()->id,
        ]);

        return response()->json([
            'message' => 'Comment created successfully'
            ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $comment = Comment::with('user')->find($id);
        if (!$comment) {
            return response()->json([
                'message' => 'Comment not found'
            ], 404);
        } else {
            return $comment;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $comment = Comment::where('id', $id)->first();
        if (!$comment) {
            return response()->json([
                'message' => 'Comment not found'
            ], 404);
        }

        if ($comment->user_id != $request->user()->id) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'body' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(), 
                400
            );
        }

        $comment->body = $request->body;
        $comment->save();

        return response()->json([
            'message' => 'Comment updated successfully'
            ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $comment = Comment::where('id', $id)->first();
        if (!$comment) {
            return response()->json([
                'message' => 'Comment not found'
            ], 404);
        } elseif ($comment->user_id != $request->user()->id) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        } else {
            $comment->delete();
            return response()->json([
                'message' => 'Comment deleted successfully'
                ], 204);
        }
    }
}
