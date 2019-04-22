<?php

namespace ConCast;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = [
        'rating', 'user_id', 'podcast_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function podcast() {
        return $this->belongsTo(Podcast::class);
    }
}
