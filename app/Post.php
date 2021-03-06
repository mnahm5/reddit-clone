<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Orderable;

class Post extends Model
{
    use Orderable;

    protected $fillable = ['title', 'body'];

    public function sub_reddit()
    {
        return $this->belongsTo(SubReddit::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->oldestFirst();
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
