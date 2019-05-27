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
use Validator;
use Illuminate\Support\Str;
use ConCast\Audio;
use ConCast\Helper\Helper;

class PodcastController extends Controller
{
    public function index() {
        $channels = Channel::where('user_id', Auth::user()->id)->get();

        if (count($channels)) {
            return view('upload', compact('channels'));
        } else {
            return redirect ('/channel/create')->withErrors(['You have to create a channel before uploading a podcast!']);
        }
    }

    public function audioUpload(Request $request) {
        $audioFile = $request->file('audio');

        if ($audioFile != null) {
            $validator = Validator::make($request->all(), [
                'audio' => 'mimes:mpga,wav',
            ]);

            if ($validator->fails()) {
                return false;
            } else {
                $audioFileName = Str::uuid()->toString();
                
                $audio_file_length = new \wapmorgan\Mp3Info\Mp3Info($audioFile->getRealPath(), true);

                $audio = Audio::create([
                    'audio_file_name' => $audioFileName,
                    'audio_file_extension' => $audioFile->getClientOriginalExtension(),
                    'audio_file_type' => $audioFile->getMimeType(),
                    'audio_file_size' => $audioFile->getSize(),
                    'audio_file_length' => $audio_file_length->duration
                ]);

                if ($audio) {
                    $audioFile->move('storage/audio', $audioFileName.'.'.$audioFile->getClientOriginalExtension());

                    return $audio->id;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    public function store(Request $request) {
        $audioId = $this->audioUpload($request);

        if ($audioId) {
            request()->validate([
                'podcast_title' => ['required', 'min:3', 'max:75'],
                'podcast_description' => ['required', 'min:25', 'max:2000'],
                'channel_id' => ['required'],
            ]);

            $podcast = Podcast::create([
                'podcast_title' => request('podcast_title'),
                'podcast_description' => request('podcast_description'),
                'channel_id' => request('channel_id'),
                'audio_id' => $audioId
            ]);
            
            return redirect('/channel/' . request('channel_id') . '/podcast/' . $podcast->id)->with('message', 'Podcast ' . request('podcast_title') . ' uploaded!');
        } else {
            return redirect('/upload')->withErrors(['The audio must be a file of type: mpga, wav.']);
        }
    }

    public function show(Channel $channel, Podcast $podcast) {
        $podcast = Podcast::with('channel')->with('comment')->findOrFail($podcast->id);

        $latestUpload = Podcast::orderByDesc('created_at')->first();

        $timeAgo = Helper::calculatePostTime($podcast->created_at);

        $audioLength = Helper::calculateAudioLength($podcast->audio->audio_file_length);

        return view('podcast.show', compact('podcast', 'latestUpload', 'timeAgo', 'audioLength'));
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
}
