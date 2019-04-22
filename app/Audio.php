<?php

namespace ConCast;

use Illuminate\Database\Eloquent\Model;

class Audio extends Model
{
	protected $fillable = [
		'audio_file_name', 'audio_file_extension', 'audio_file_type', 'audio_file_size', 'audio_file_length'
	];

    public function audio() {
    	return $this->hasMany(Podcast::class);
    }
}
