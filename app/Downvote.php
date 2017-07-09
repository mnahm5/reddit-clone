<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Downvote extends Model
{
    public function downVoteAble()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
