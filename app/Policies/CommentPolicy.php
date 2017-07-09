<?php

namespace App\Policies;

use App\Comment;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Comment $comment)
    {
        dd($user->id);
        return $user->ownsComment($comment);
    }

    public function destroy(User $user, Comment $comment)
    {
        return $user->ownsComment($comment);
    }

    public function upvote(User $user, Comment $comment)
    {
        return !$user->ownsComment($comment);
    }

    public function downvote(User $user, Comment $comment)
    {
        return !$user->ownsComment($comment);
    }
}
