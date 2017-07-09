<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdateSubRedditRequest;
use App\Post;
use App\SubReddit;
use App\Transformers\PostTransformer;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(StorePostRequest $request, SubReddit $sub_reddit)
    {
        $post = new Post;
        $post->title = $request->title;
        $post->body = $request->body;
        $post->user()->associate($request->user());

        $sub_reddit->posts()->save($post);

        return fractal()
            ->item($post)
            ->parseIncludes(['user'])
            ->transformWith(new PostTransformer)
            ->toArray();
    }

    public function update(UpdateSubRedditRequest $request, SubReddit $sub_reddit, Post $post)
    {
        $this->authorize('update', $post);

        $post->title = $request->get('title', $post->title);
        $post->body = $request->get('body', $post->body);
        $post->save();

        return fractal()
            ->item($post)
            ->parseIncludes(['user'])
            ->transformWith(new PostTransformer)
            ->toArray();
    }

    public function destroy(SubReddit $sub_reddit, Post $post)
    {
        $this->authorize('destroy', $post);

        $post->delete();

        return response(null, 204);
    }

    public function show(SubReddit $sub_reddit, Post $post)
    {
        return fractal()
            ->item($post)
            ->parseIncludes(['user', 'upvotes', 'downvotes'])
            ->transformWith(new PostTransformer)
            ->toArray();
    }
}
