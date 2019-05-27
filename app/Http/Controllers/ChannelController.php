<?php

namespace ConCast\Http\Controllers;

use Illuminate\Http\Request;
use ConCast\Channel;
use ConCast\Podcast;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChannelController extends Controller
{
    public function index() {
        $channels = Channel::get();

        $latestUpload = Podcast::with('channel')->orderByDesc('created_at')->first();

        return view('channel.channel', compact('channels', 'latestUpload'));
    }

    public function show(Channel $channel) {
        $first = Podcast::find($channel);

        $latestUpload = Podcast::with('channel')->orderByDesc('created_at')->first();

        return view('channel.show', compact('channel', 'first', 'latestUpload'));
    }

    public function create() {
        if (Auth::check()) {
            return view('channel.create');
        } else {
            return redirect ('/login')->withErrors(['You have to log in before creating a channel!']);
        }
    }

    public function store() {
        request()->validate([
            'channel_name' => ['required', 'min:3', 'max:50'],
            'channel_bio' => ['max:255']
        ]);

        $channel = Channel::create([
            'channel_name' => request('channel_name'),
            'channel_bio' => request('channel_bio'),
            'channel_email' => request('channel_email'),
            'channel_facebook' => request('channel_facebook'),
            'channel_twitter' => request('channel_twitter'),
            'user_id' => Auth::user()->id
        ]);

        return redirect('/channel/' . $channel->id)->with('message', 'Channel created!');
    }

    public function edit(Channel $channel) {
        if (Auth::check()) {
            $channel = Channel::where('user_id', Auth::user()->id)->find($channel->id);

            if ($channel) {
                return view('channel.edit', compact('channel'));
            } else {
                return redirect ('/channel')->withErrors(['You are not permitted to edit this channel!']);
            }
        } else {
            return redirect ('/login')->withErrors(['You have to log in to edit a channel!']);
        }
    }

    public function update(Channel $channel) {
        $channel->update(request()->validate([
            'channel_name' => ['required', 'min:3', 'max:50'],
            'channel_bio' => ['max:255']
        ]));

        return redirect('/channel/' . $channel->id)->with('message', 'Channel updated!');
    }
}
