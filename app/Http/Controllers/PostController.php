<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Post::with('user','comments')->simplePaginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(), 
                400
            );
        }

        $post = Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => $request->user()->id,
        ]);

        return response()->json([
            'message' => 'Post created successfully'
            ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::with('user','comments')->find($id);
        if (!$post) {
            return response()->json([
                'message' => 'Post not found'
            ], 404);
        } else {
            return $post;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::where('id', $id)->first();
        if (!$post) {
            return response()->json([
                'message' => 'Post not found'
            ], 404);
        } elseif ($post->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        } else {
            $validator = Validator::make($request->all(), [
                'title' => 'string|max:255',
                'body' => 'string',
            ]);

            if ($validator->fails()) {
                return response()->json(
                    $validator->errors(), 
                    400
                );
            }

            if($request->has('title')){
                $post->title = $request->title;
            }

            if($request->has('body')){
                $post->body = $request->body;
            }

            $post->save();

            return response()->json([
                'message' => 'Post updated successfully'
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $post = Post::where('id', $id)->first();
        if (!$post) {
            return response()->json([
                'message' => 'Post not found'
            ], 404);
        } elseif ($post->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        } else {
            $post->delete();
            return response()->json([
                'message' => 'Post deleted successfully'
            ], 204);
        }
    }
}
