<?php

namespace App\Transformers;

use App\Comment;
use App\Post;

class CommentTransformer extends \League\Fractal\TransformerAbstract
{
    protected $availableIncludes = ['user', 'upvotes', 'downvotes'];

    public function transform(Comment $comment) {
        return [
            'id' => $comment->id,
            'body' => $comment->body,
            'upvotes_count' => $comment->upvotes->count(),
            'downvotes_count' => $comment->downvotes->count(),
            'created_at' => $comment->created_at->toDateTimeString(),
            'created_at_human' => $comment->created_at->diffForHumans()
        ];
    }

    public function includeUser(Comment $comment)
    {
        return $this->item($comment->user, new UserTransformer);
    }

    public function includeUpvotes(Comment $comment)
    {
        return $this->collection($comment->upvotes->pluck('user'), new UserTransformer);
    }

    public function includeDownvotes(Comment $comment)
    {
        return $this->collection($comment->downvotes->pluck('user'), new UserTransformer);
    }
}
