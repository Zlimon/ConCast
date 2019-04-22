<?php

namespace ConCast\Http\Controllers;

use Illuminate\Http\Request;
use ConCast\Channel;
use ConCast\Audio;
use ConCast\Image;
use ConCast\Podcast;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class FileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

   public function index() {
        $channels = Channel::where('user_id', Auth::user()->id)->get();

        if (count($channels)) {
            return view('upload', compact('channels'));
        } else {
            return redirect ('/channel/create')->withErrors(['You have to create a channel before uploading a podcast!']);
        }
   }

   public function verify(Request $request) {
        $audioFile = $request->file('audio');
        $imageFile = $request->file('image');

        if ($audioFile != null && $imageFile != null) {
            $validator = Validator::make($request->all(), [
                'audio' => 'mimes:mpga,wav',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors(($validator->errors()));
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
                    $destinationPath = 'storage';

                    $validator = Validator::make($request->all(), [
                        'image' => 'mimes:jpeg,bmp,png,gif',
                    ]);
                    if ($validator->fails()) {
                        return redirect()->back()->withErrors(($validator->errors()));
                    } else {
                        $imageFileName = Str::uuid()->toString();

                        $image = Image::create([
                            'image_file_name' => $imageFileName,
                            'image_file_extension' => $imageFile->getClientOriginalExtension(),
                            'image_file_type' => $imageFile->getMimeType(),
                            'image_file_size' => $imageFile->getSize()
                        ]);

                        if ($image) {
                            $audioId = $audio->id;
                            $imageId = $image->id;

                            $audioFile->move($destinationPath, $audioFileName . '.' . $audioFile->getClientOriginalExtension());
                            $imageFile->move($destinationPath, $imageFileName . '.' . $imageFile->getClientOriginalExtension());

                            return $this->store($audioId, $imageId);
                        } else {
                            return redirect()->back()->withErrors(($image->errors()));
                        }
                    }
                } else {
                    return redirect()->back()->withErrors(($audio->errors()));
                }
            }
        } else {
            return redirect()->back()->withErrors('You have to upload an audio file and an image file');
        }
    }

    public function store($audioId, $imageId) {
        request()->validate([
            'podcast_title' => ['required', 'min:3', 'max:75'],
            'podcast_description' => ['required', 'min:25', 'max:2000'],
            'channel_id' => ['required'],
        ]);

        $podcast = Podcast::create([
            'podcast_title' => request('podcast_title'),
            'podcast_description' => request('podcast_description'),
            'channel_id' => request('channel_id'),
            'channel_id' => request('channel_id'),
            'audio_id' => $audioId,
            'image_id' => $imageId
        ]);
        
        return redirect('/channel/' . request('channel_id') . '/podcast/' . $podcast->id)->with('message', 'Podcast ' . request('podcast_title') . ' uploaded!');
    }
}
