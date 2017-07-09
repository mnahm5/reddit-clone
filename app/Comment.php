<?php

namespace App;

use App\Traits\Orderable;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use Orderable;

    protected $fillable = ['body'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function upvotes()
    {
        return $this->morphMany(Upvote::class, 'upvoted');
    }

    public function downvotes()
    {
        return $this->morphMany(Downvote::class, 'downvoted');
    }
}
