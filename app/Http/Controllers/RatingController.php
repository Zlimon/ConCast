<?php

namespace ConCast\Http\Controllers;

use Illuminate\Http\Request;
use ConCast\Channel;
use ConCast\Podcast;

class RatingController extends Controller
{
    public function store(Channel $channel, Podcast $podcast) {
        $podcast->storeRating();

        return redirect()->back()->with('message', 'Rated ' . $podcast->podcast_title . '!');
    }
}
