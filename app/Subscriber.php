<?php

namespace ConCast;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $guarded = [];
 
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
