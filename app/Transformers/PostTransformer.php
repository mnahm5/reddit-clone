<?php

namespace App\Transformers;

use App\Post;

class PostTransformer extends \League\Fractal\TransformerAbstract
{
    protected $availableIncludes = ['user', 'upvotes', 'downvotes'];

    public function transform(Post $post) {
        return [
            'id' => $post->id,
            'title' => $post->title,
            'body' => $post->body,
            'upvotes_count' => $post->upvotes->count(),
            'downvotes_count' => $post->downvotes->count(),
            'created_at' => $post->created_at->toDateTimeString(),
            'created_at_human' => $post->created_at->diffForHumans()
        ];
    }

    public function includeUser(Post $post)
    {
        return $this->item($post->user, new UserTransformer);
    }

    public function includeUpvotes(Post $post)
    {
        return $this->collection($post->upvotes->pluck('user'), new UserTransformer);
    }

    public function includeDownvotes(Post $post)
    {
        return $this->collection($post->downvotes->pluck('user'), new UserTransformer);
    }
}
