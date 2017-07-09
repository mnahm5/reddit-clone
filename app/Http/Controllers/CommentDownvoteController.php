<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Downvote;
use App\Post;
use App\SubReddit;
use Illuminate\Http\Request;

class CommentDownvoteController extends Controller
{
    public function store(Request $request, SubReddit $sub_reddit, Post $post, Comment $comment)
    {
        $this->authorize('downvote', $comment);

        if ($request->user()->hasDownvotedComment($comment)) {
            return response(null, 409);
        }

        if ($request->user()->hasUpvotedComment($comment)) {
            $comment->upvotes->where('user_id', $request->user()->id)[0]->delete();
        }

        $downvote = new Downvote;
        $downvote->user()->associate($request->user());
        $comment->downvotes()->save($downvote);

        return response(null, 204);
    }
}
