<?php

namespace App\Http\Controllers;

use App\Downvote;
use App\Post;
use App\SubReddit;
use Illuminate\Http\Request;

class PostDownvoteController extends Controller
{
    public function store(Request $request, SubReddit $sub_reddit, Post $post)
    {
        $this->authorize('downvote', $post);

        if ($request->user()->hasDownvotedPost($post)) {
            return response(null, 409);
        }

        if ($request->user()->hasUpvotedPost($post)) {
            $post->upvotes->where('user_id', $request->user()->id)[0]->delete();
        }

        $downvote = new Downvote;
        $downvote->user()->associate($request->user());
        $post->downvotes()->save($downvote);

        return response(null, 204);
    }
}
