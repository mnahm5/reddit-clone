<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use App\SubReddit;
use App\Upvote;
use Illuminate\Http\Request;

class CommentUpvoteController extends Controller
{
    public function store(Request $request, SubReddit $sub_reddit, Post $post, Comment $comment)
    {
        $this->authorize('upvote', $comment);

        if ($request->user()->hasUpvotedComment($comment)) {
            return response(null, 409);
        }

        if ($request->user()->hasDownvotedComment($comment)) {
            $comment->downvotes->where('user_id', $request->user()->id)[0]->delete();
        }

        $upvote = new Upvote;
        $upvote->user()->associate($request->user());
        $comment->upvotes()->save($upvote);

        return response(null, 204);
    }
}
