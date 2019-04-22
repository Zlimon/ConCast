<?php

namespace ConCast\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ConCast\Channel;
use ConCast\Podcast;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        // $channels = Channel::where('user_id', Auth::user()->id)->get();
        // $podcasts = Podcast::where('channel_id', $channels->channel->id);

        //$podcasts = Podcast::with('channel')->get();
        $channels = Channel::where('user_id', Auth::user()->id)->with('podcasts')->get();

     //    foreach ($channels as $channel) {
     //    	//dd($channel->podcasts);
     //    	// for ($i=0; $i < 6; $i++) { 
     //    	// 	dd($channel->podcasts[$i]->podcast_title);
     //    	// }

     //    	foreach ($channel->podcasts as $podcast) {
     //    		dd($podcast->podcast_title);
     //    	}
    	// }


     //    foreach ($podcasts as $podcast) {
     //    	dd($podcast->podcast_title, $podcast->channel);
    	// }

    	// $channels = Channel::with('podcasts')->get();

    	// foreach ($channels as $channel) {
    	// 	dd ($channel->podcasts->podcast_title, $channel->channel_name);
    	// }

        return view('profile', compact('channels'));
    }
}
