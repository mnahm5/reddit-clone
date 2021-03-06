<?php

namespace App\Http\Controllers;

use App\Post;
use App\SubReddit;
use App\Upvote;
use Illuminate\Http\Request;

class PostUpvoteController extends Controller
{
    public function store(Request $request, SubReddit $sub_reddit, Post $post)
    {
        $this->authorize('upvote', $post);

        if ($request->user()->hasUpvotedPost($post)) {
            return response(null, 409);
        }

        if ($request->user()->hasDownvotedPost($post)) {
            $post->downvotes->where('user_id', $request->user()->id)[0]->delete();
        }

        $upvote = new Upvote;
        $upvote->user()->associate($request->user());
        $post->upvotes()->save($upvote);

        return response(null, 204);
    }
}
