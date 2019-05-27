<?php

namespace ConCast\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use ConCast\Channel;
use ConCast\Podcast;

class ProfileController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $channels = Channel::where('user_id', Auth::user()->id)->with('podcasts')->get();

        return view('profile.profile', compact('channels'));
    }

    public function channel() {
        $channels = Channel::where('user_id', Auth::user()->id)->with('podcasts')->get();

        return view('profile.channel', compact('channels'));
    }

    public function podcast() {
        $channels = Channel::where('user_id', Auth::user()->id)->with('podcasts')->get();

        return view('profile.podcast', compact('channels'));
    }

    public function edit() {
        return view('profile.edit');
    }

    public function update() {
        Auth::user()->update(request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 
                Rule::unique('users')->ignore(Auth::user()->id),
            ]
        ]));

        if (request('password')) {
            request()->validate([
                'oldpassword' => ['required', 'string', 'min:8'],
                'password' => ['required', 'string', 'min:8', 'confirmed']
            ]);

            $hashedPassword = Auth::user()->password;

            if (\Hash::check(request('oldpassword') , $hashedPassword)) {
                if (!\Hash::check(request('password') , $hashedPassword)) {
                    $password = bcrypt(request('password'));
                    Auth::user()->update([
                        'password' => $password,
                    ]);

                    return redirect('/profile/edit')->with('message', 'Profile updated!');
                } else {
                    return redirect ('/profile/edit')->withErrors(['New password can not be old password!']);
                }
            } else{
                return redirect ('/profile/edit')->withErrors(['Old password is not corect!']);
            }
        }

        return redirect('/profile/edit')->with('message', 'Profile updated!');
    }
}
