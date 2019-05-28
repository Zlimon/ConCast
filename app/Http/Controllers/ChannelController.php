<?php

namespace ConCast\Http\Controllers;

use Illuminate\Http\Request;
use ConCast\Channel;
use ConCast\Podcast;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Str;
use ConCast\Image;

use ConCast\Subscriber;

class ChannelController extends Controller
{
    public function index() {
        $channels = Channel::get();

        return view('channel.channel', compact('channels'));
    }

    public function show(Channel $channel) {
        return view('channel.show', compact('channel', 'first', 'latestUpload'));
    }

    public function create() {
        if (Auth::check()) {
            return view('channel.create');
        } else {
            return redirect ('/login')->withErrors(['You have to log in before creating a channel!']);
        }
    }

    public function imageUpload(Request $request) {
        $imageFile = $request->file('image');

        if ($imageFile != null) {
            $validator = Validator::make($request->all(), [
                'image' => 'mimes:jpeg,bmp,png,gif',
            ]);

            if ($validator->fails()) {
                return false;
            } else {
                $imageFileName = Str::uuid()->toString();

                $image = Image::create([
                    'image_file_name' => $imageFileName,
                    'image_file_extension' => $imageFile->getClientOriginalExtension(),
                    'image_file_type' => $imageFile->getMimeType(),
                    'image_file_size' => $imageFile->getSize(),
                ]);

                if ($image) {
                    $imageFile->move('storage/image', $imageFileName.'.'.$imageFile->getClientOriginalExtension());

                    return $image->id;
                } else {
                    return false;
                }
            }
        } else {
            return 1;
        }
    }

    public function store(Request $request) {
        $imageId = $this->imageUpload($request);

        if ($imageId) {
            request()->validate([
                'channel_name' => ['required', 'min:3', 'max:50'],
                'channel_bio' => ['max:1000']
            ]);

            $channel = Channel::create([
                'channel_name' => request('channel_name'),
                'channel_bio' => request('channel_bio'),
                'channel_email' => request('channel_email'),
                'channel_facebook' => request('channel_facebook'),
                'channel_twitter' => request('channel_twitter'),
                'image_id' => $imageId,
                'user_id' => Auth::user()->id
            ]);

            return redirect('/channel/' . $channel->id)->with('message', 'Channel created!');
        } else {
            return redirect('/upload')->withErrors(['The image must be a file of type: jpeg, bmp, png, gif.']);
        }
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
            'channel_bio' => ['max:1000']
        ]));

        return redirect('/channel/' . $channel->id)->with('message', 'Channel updated!');
    }
}
