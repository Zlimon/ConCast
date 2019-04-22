<?php

namespace ConCast\Http\Controllers;

use Illuminate\Http\Request;
use ConCast\Channel;
use ConCast\Podcast;

class CommentController extends Controller
{
    public function store(Channel $channel, Podcast $podcast) {
        $podcast->storeComment();

        return redirect()->back()->with('message', 'Comment posted!');
    }
}
