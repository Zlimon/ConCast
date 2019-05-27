<?php

namespace ConCast\Http\Controllers;

use Illuminate\Http\Request;
use ConCast\Podcast;
use ConCast\Channel;

class SearchController extends Controller
{
    public function index() {
        $searchQuery = null;

        return view('search', compact('searchQuery', 'podcasts', 'channels'));
    }

    public function search() {
        request()->validate([
            'search' => ['required', 'string', 'min:1', 'max:200'],
        ]);

        $searchQuery = request('search');

        $podcasts = Podcast::where(function($query) use ($searchQuery) {
            $query->where('podcast_title', 'LIKE', '%' . $searchQuery . '%')
                ->orWhere('podcast_description', 'LIKE', '%' . $searchQuery . '%');
        })->paginate(10);

        $latestUpload = Podcast::orderByDesc('created_at')->first();

        $channels = Channel::where('channel_name', 'LIKE', '%' . $searchQuery . '%')->paginate(10);

        if (count($podcasts) === 0 && count($channels) === 0) {
            return redirect('/search')->withErrors(['No search results for "'.$searchQuery.'"!']);
        } else {
            return view('search', compact('podcasts', 'latestUpload',  'channels', 'searchQuery'));
        }
    }
}
