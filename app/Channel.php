<?php

namespace ConCast;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $fillable = [
        'channel_name', 'channel_bio', 'channel_email', 'channel_facebook', 'channel_twitter','user_id'
    ];

    // protected $guarded = [];

    public function podcasts() {
        return $this->hasMany(Podcast::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id()
        ]);
        return $this;
    }

    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
            ->where('user_id', $userId ?: auth()->id())
            ->delete();
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscriber::class);
    }
}
