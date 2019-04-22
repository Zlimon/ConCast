<?php

namespace ConCast\Http\Controllers;

use Illuminate\Http\Request;
use ConCast\Podcast;
use ConCast\Channel;
use ConCast\Subscriber;
use ConCast\Comment;
use \ConCast\Http\Controllers\CalculateTime;
use ConCast\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PodcastController extends Controller
{
    public function show(Channel $channel, Podcast $podcast) {
        $podcast = Podcast::where('channel_id', $channel->id)->with('comment')->findOrFail($podcast->id);

        $latestPodcast = Podcast::find($podcast->id)->orderbyDesc('created_at')->first();
        $latestUpload = Carbon::parse($latestPodcast->created_at)->diffForHumans();

        $timeAgo = CalculateTime::calculatePostTime($podcast->created_at);

        $audioLength = CalculateTime::calculateAudioLength($podcast->audio->audio_file_length);

        $channelSubscriptions = Channel::with('subscriptions')->count();

        if (Auth::check()) {
            $userSubscriber = Subscriber::where('user_id', Auth::user()->id)->with('channel')->first();
        }


        return view('podcast.show', compact('podcast', 'latestUpload', 'timeAgo', 'audioLength', 'channelSubscriptions', 'userSubscriber'));
    }

    public function edit(Channel $channel, Podcast $podcast) {
        if (Auth::check()) {
            $channel = Channel::where('user_id', Auth::user()->id)->find($channel->id);

            if ($channel) {
                return view('podcast.edit', compact('podcast'));
            } else {
                return redirect ('/channel/' . $podcast->channel->id . '/podcast/' . $podcast->id)->withErrors(['You are not permitted to edit this podcast!']);
            }
        } else {
            return redirect ('/login')->withErrors(['You have to log in to edit a podcast!']);
        }
    }

    public function update(Channel $channel, Podcast $podcast) {
        $podcast->update(request()->validate([
            'podcast_title' => ['required', 'min:3', 'max:75'],
            'podcast_description' => ['required', 'min:25', 'max:2000']
        ]));

        return redirect('/channel/' . $podcast->channel->id . '/podcast/' . $podcast->id)->with('message', 'Podcast updated!');
    }

    // public function postComment(Channel $channel, Podcast $podcast) {
    //     request()->validate([
    //         'comment_text' => ['required', 'min:3', 'max:1000']
    //     ]);

    //     $comment = Comment::create([
    //         'comment_text' => request('comment_text'),
    //         'user_id' => Auth::user()->id,
    //         'podcast_id' => $podcast->id
    //     ]);

    //     return redirect('/channel/' . $podcast->channel->id . '/podcast/' . $podcast->id)->with('message', 'Comment posted!');
    // }

    // public function ratePodcast(Channel $channel, Podcast $podcast) {
    //     request()->validate([
    //         'rating' => ['required']
    //     ]);

    //     $comment = Comment::create([
    //         'rating' => request('rating'),
    //         'user_id' => Auth::user()->id,
    //         'podcast_id' => $podcast->id
    //     ]);

    //     return redirect('/channel/' . $podcast->channel->id . '/podcast/' . $podcast->id)->with('message', 'Podcast rated!');
    // }
}
