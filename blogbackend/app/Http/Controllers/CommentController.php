<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function index($id)
    {

        $post = Post::find($id);
        if (!$post) {
            return response(
                [
                    'message' => 'post not found',
                ],
                403
            );
        }
        return response([
            'post' => $post->comments()->with('user:id,name,image')->get()
        ], 200);

    }


    public function store(Request $request, $id)
    {
        // check post is available in database or not
        $post = Post::find($id);
        if (!$post) {
            return response(
                [
                    'message' => 'post not found',
                ],
                403
            );
        }

        $validateData = $request->validate([
            'comment' => 'required|string'

        ]);
        Comment::create([
            'comment' => $validateData['comment'],
            'post_id' => $id,
            'user_id' => auth()->user()->id
        ]);

        return response([
            'message' => 'Comment created'
        ], 200);

    }




    public function update(Request $request, $id)
    {
        $comment = Comment::find($id);
        if (!$comment) {
            return response([
                'message' => 'Comment not found',
            ], 403);

        }

        // authorization to update

        if ($comment->user_id != auth()->user()->id) {
            return response([
                'message' => 'Permission denied'
            ], 403);
        }


        $validatedData = $request->validate([
            'comment' => 'required|string',
        ]);

        $comment->update(
            [
                'comment' => $validatedData['body'],


            ]
        );
        // Just skip for image now because it requires to store path in server and store image in local storage
        return response([
            'message' => "Comment created successfully",
        ], 200);

    }



    public function destroy($id)
    {
        $comment = Comment::find($id);
        if (!$comment) {
            return response([
                'message' => 'comment not found',
            ], 403);

        }

        // authorization to update

        if ($comment->user_id != auth()->user()->id) {
            return response([
                'message' => 'Permission denied'
            ], 403);
        }


        $comment()->delete();



        return response([
            'message' => "Comment Deleted successfully",
        ], 200);

    }

}