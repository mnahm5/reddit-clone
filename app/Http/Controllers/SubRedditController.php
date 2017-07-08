<?php

namespace App\Http\Controllers;

use App\Post;
use App\SubReddit;
use App\Transformers\SubRedditTransformer;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSubRedditRequest;

class SubRedditController extends Controller
{
    public function store(StoreSubRedditRequest $request)
    {
        $sub_reddit = new SubReddit;
        $sub_reddit->title = $request->title;
        $sub_reddit->user()->associate($request->user());

        $post = new Post;
        $post->title = $request->title . " Sub Reddit Created";
        $post->body = $request->body;
        $post->user()->associate($request->user());

        $sub_reddit->save();
        $sub_reddit->posts()->save($post);

        return fractal()
            ->item($sub_reddit)
            ->parseIncludes(['user'])
            ->transformWith(new SubRedditTransformer)
            ->toArray();
    }
}
