<?php

namespace App\Policies;

use App\SubReddit;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubRedditPolicy
{
    use HandlesAuthorization;

    public function update(User $user, SubReddit $sub_reddit)
    {
        return $user->ownsSubReddit($sub_reddit);
    }
}
