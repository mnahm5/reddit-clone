<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Upvote extends Model
{
    public function upVoteAble()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
