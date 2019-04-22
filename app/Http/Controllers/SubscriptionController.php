<?php

namespace ConCast\Http\Controllers;

use Illuminate\Http\Request;
use ConCast\Channel;

class SubscriptionController extends Controller
{
    public function store(Channel $channel)
    {
        $channel->subscribe();

        return redirect()->back()->with('message', 'Subscribed to ' . $channel->channel_name . '!');
    }

    public function destroy(Channel $channel)
    {
        $channel->unsubscribe();

        return redirect()->back()->withErrors(['Unsubscribed to ' . $channel->channel_name . '!']);
    }
}
