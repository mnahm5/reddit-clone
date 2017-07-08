<?php

namespace App\Transformers;

use App\SubReddit;

class SubRedditTransformer extends \League\Fractal\TransformerAbstract
{
    protected $availableIncludes = ['user', 'posts'];

    public function transform(SubReddit $sub_reddit) {
        return [
            'id' => $sub_reddit->id,
            'title' => $sub_reddit->title,
            'created_at' => $sub_reddit->created_at->toDateTimeString(),
            'created_at_human' => $sub_reddit->created_at->diffForHumans()
        ];
    }

    public function includeUser(SubReddit $sub_reddit)
    {
        return $this->item($sub_reddit->user, new UserTransformer);
    }

    public function includePosts(SubReddit $sub_reddit)
    {
        return $this->collection($sub_reddit->posts, new PostTransformer);
    }
}
