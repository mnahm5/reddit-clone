<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Post;
use App\SubReddit;
use App\Transformers\CommentTransformer;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, SubReddit $sub_reddit, Post $post)
    {
        $comment = new Comment;
        $comment->body = $request->body;
        $comment->user()->associate($request->user());

        $post->comments()->save($comment);

        return fractal()
            ->item($comment)
            ->parseIncludes(['user'])
            ->transformWith(new CommentTransformer)
            ->toArray();
    }

    public function update(UpdateCommentRequest $request, SubReddit $sub_reddit, Post $post, Comment $comment)
    {
        $this->authorize('update', $comment);

        $comment->body = $request->get('body', $comment->body);
        $comment->save();

        return fractal()
            ->item($comment)
            ->parseIncludes(['user'])
            ->transformWith(new CommentTransformer)
            ->toArray();
    }

    public function destroy(SubReddit $sub_reddit, Post $post, Comment $comment)
    {
        $this->authorize('destroy', $comment);

        $comment->delete();

        return response(null, 204);
    }

    public function show(SubReddit $sub_reddit, Post $post, Comment $comment)
    {
        return fractal()
            ->item($comment)
            ->parseIncludes(['user', 'upvotes', 'downvotes'])
            ->transformWith(new CommentTransformer)
            ->toArray();
    }
}
