<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response([
            "posts" => Post::orderBy("created_at", "desc")->with("user:id,name,image")->withCount(' ', 'likes')
                ->with(
                    'likes',
                    function ($like) {
                        return $like->where('user_id', auth()->user()->id)->select('id', 'user_id', 'post_id')->get();
                    }
                )
                ->get()
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'body' => 'required|string',
        ]);

        $image = $this->saveImage($request->image, 'posts');


        $post = Post::create([
            'body' => $validatedData['body'],
            'user_id' => auth()->user()->id,
            'image' => $image,
        ]);

        return response([
            'message' => "Post created successfully",
            'post' => $post
        ], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return response([
            'post' => Post::where('id', $id)->withCount('comments', 'likes')->get()
        ], 200);


    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response([
                'message' => 'post not found',
            ], 403);

        }

        // authorization to update

        if ($post->user_id != auth()->user()->id) {
            return response([
                'message' => 'Permission denied'
            ], 403);
        }


        $validatedData = $request->validate([
            'body' => 'required|string',
        ]);

        $post->update(
            [
                'body' => $validatedData['body'],


            ]
        );
        // Just skip for image now because it requires to store path in server and store image in local storage
        return response([
            'message' => "Post update successfully",
            'post' => $post
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response([
                'message' => 'post not found',
            ], 403);

        }

        // authorization to update

        if ($post->user_id != auth()->user()->id) {
            return response([
                'message' => 'Permission denied'
            ], 403);
        }


        $post->comments()->delete();
        $post->likes()->delete();
        $post->delete();


        return response([
            'message' => "Post Deleted successfully",
        ], 200);

    }
}
