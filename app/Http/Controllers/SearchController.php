<?php

namespace ConCast\Http\Controllers;

use Illuminate\Http\Request;
use ConCast\Podcast;
use ConCast\Channel;

class SearchController extends Controller
{
    public function index() {
        $query = null;

        return view('search', compact('query', 'podcasts', 'channels'));
    }

    public function search() {
        request()->validate([
            'search' => ['required', 'string', 'min:1', 'max:200'],
        ]);

        $query = request('search');

        $podcasts = Podcast::where('podcast_title', 'LIKE', '%' . $query . '%')->paginate(10);

        $latestUpload = Podcast::orderByDesc('created_at')->first();

        $channels = Channel::where('channel_name', 'LIKE', '%' . $query . '%')->paginate(10);

        if (count($podcasts) === 0 && count($channels) === 0) {
            return redirect('/search')->withErrors(['No search results for "'.$query.'"!']);
        } else {
            return view('search', compact('podcasts', 'latestUpload',  'channels', 'query'));
        }
    }
}
