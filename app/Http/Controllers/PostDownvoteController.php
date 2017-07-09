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

        $downvote = new Downvote;
        $downvote->user()->associate($request->user());
        $post->downvotes()->save($downvote);

        return response(null, 204);
    }
}
