<?php

namespace ConCast\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use ConCast\Podcast;
use ConCast\Channel;

class PagesController extends Controller
{
    public function index() {
        $recentPodcasts = Podcast::orderByDesc('created_at')->limit(5)->get();

        $popularPodcasts = Podcast::inRandomOrder()->limit(3)->get();

        $popularChannels = Channel::inRandomOrder()->limit(3)->get();

        $suggestedPodcasts = Podcast::inRandomOrder()->limit(3)->get();

        return view('index', compact('recentPodcasts', 'popularPodcasts', 'popularChannels', 'suggestedPodcasts'));
    }

    public function discover() {
        $discoverPodcasts = Podcast::inRandomOrder()->get();

        return view('discover', compact('discoverPodcasts'));
    }

    public function upgrade() {
        return view('upgrade');
    }
}
