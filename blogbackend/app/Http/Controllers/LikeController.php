<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;


class LikeController extends Controller
{
    public function likeDislike(Request $request, $id)
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

        $like = $post->likes()->where('user_id', auth()->user()->id)->first();

        if ($like) {
            // User has already liked the post, so we'll assume this is a dislike action
            $like->delete();
            return response([
                'message' => 'Post disliked'
            ], 200);
        } else {
            // User has not liked the post yet, so we'll create a new like
            Like::create([
                'post_id' => $id,
                'user_id' => auth()->user()->id
            ]);
            return response([
                'message' => 'Post liked'
            ], 200);
        }
    }
}
