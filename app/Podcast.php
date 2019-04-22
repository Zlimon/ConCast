<?php

namespace ConCast;

use Illuminate\Database\Eloquent\Model;

class Podcast extends Model
{
    protected $fillable = [
        'podcast_title', 'podcast_description', 'channel_id', 'audio_id', 'image_id'
    ];

    public function channel() {
        return $this->belongsTo(Channel::class);
    }

    public function audio() {
        return $this->belongsTo(Audio::class);
    }

    public function image() {
        return $this->belongsTo(Image::class);
    }

    public function storeComment($userId = null) {
        if (auth()->id()) {
            $this->comment()->create([
                'comment_text' => request('comment_text'),
                'user_id' => $userId ?: auth()->id(),
                'podcast_id' => $this->id
            ]);

            return $this;
        } else {
            return redirect ('/login')->withErrors(['You have to log in to comment on a podcast!']);
        }
    }

    public function comment() {
        return $this->hasMany(Comment::class);
    }

    public function storeRating($userId = null) {
        if (auth()->id()) {
            if (Rating::where('user_id', auth()->id())->where('podcast_id', $this->id)->exists()) {
                $this->update(request()->validate([
                    'rating' => ['required']
                ]));

                return $this;
            } else {
                request()->validate([
                    'rating' => ['required']
                ]);

                $this->rating()->create([
                    'rating' => request('rating'),
                    'user_id' => $userId ?: auth()->id(),
                    'podcast_id' => $this->id
                ]);

                return $this;
            }
        } else {
            return redirect ('/login')->withErrors(['You have to log in to rate a podcast!']);
        }
    }

    public function rating() {
        return $this->hasMany(Rating::class);
    }
}
