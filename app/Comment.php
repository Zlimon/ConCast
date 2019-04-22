<?php

namespace ConCast;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'comment_text', 'user_id', 'podcast_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function podcast() {
        return $this->belongsTo(Podcast::class);
    }
}
