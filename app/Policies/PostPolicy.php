<?php

namespace App\Policies;

use App\Post;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Post $post)
    {
        return $user->ownsPost($post);
    }

    public function destroy(User $user, Post $post)
    {
        return $user->ownsPost($post);
    }

    public function upvote(User $user, Post $post)
    {
        return !$user->ownsPost($post);
    }

    public function downvote(User $user, Post $post)
    {
        return !$user->ownsPost($post);
    }
}
