<?php

namespace App\Http\Controllers;

use App\Post;
use App\SubReddit;
use App\Transformers\SubRedditTransformer;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSubRedditRequest;
use App\Http\Requests\UpdateSubRedditRequest;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class SubRedditController extends Controller
{
    public function index()
    {
        $sub_reddits = SubReddit::latestFirst()->paginate(10);
        $sub_reddits_collection = $sub_reddits->getCollection();

        return fractal()
            ->collection($sub_reddits_collection)
            ->parseIncludes(['user'])
            ->transformWith(new SubRedditTransformer)
            ->paginateWith(new IlluminatePaginatorAdapter($sub_reddits))
            ->toArray();
    }

    public function show(SubReddit $sub_reddit)
    {
        return fractal()
            ->item($sub_reddit)
            ->parseIncludes(['user', 'posts', 'posts.user'])
            ->transformWith(new SubRedditTransformer)
            ->toArray();
    }

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

    public function update(UpdateSubRedditRequest $request, SubReddit $sub_reddit)
    {
        $this->authorize('update', $sub_reddit);

        $sub_reddit->title = $request->get('title', $sub_reddit->title);
        $sub_reddit->save();

        return fractal()
            ->item($sub_reddit)
            ->parseIncludes(['user'])
            ->transformWith(new SubRedditTransformer)
            ->toArray();
    }

    public function destroy(SubReddit $sub_reddit)
    {
        $this->authorize('destroy', $sub_reddit);
        $sub_reddit->delete();

        return response(null, 204);
    }
}
