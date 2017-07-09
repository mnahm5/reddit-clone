<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function avatar()
    {
        return 'http://www.gravatar.com/avatar/' . md5($this->email) . '?s=45&d=mm';
    }

    public function ownsSubReddit(SubReddit $sub_reddit)
    {
        return $this->id === $sub_reddit->user->id;
    }

    public function ownsPost(Post $post)
    {
        return $this->id === $post->user->id;
    }

    public function hasUpvotedPost(Post $post)
    {
        return $post->upvotes->where('user_id', $this->id)->count() === 1;
    }

}
