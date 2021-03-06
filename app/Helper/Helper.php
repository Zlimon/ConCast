<?php

namespace ConCast\Helper;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use ConCast\Subscriber;

class Helper
{
    public static function getUserSubscriber($channelId) {
        $checkIfUserSubscribed = Subscriber::with('channel')->where('user_id', Auth::user()->id)->where('channel_id', $channelId)->first();

        if ($checkIfUserSubscribed) {
            return true;
        } else {
            return false;
        }
    }

    public static function calculatePostTime($createData) {
        $timeAgo = Carbon::parse($createData)->diffForHumans();

        return $timeAgo;
    }

    public static function calculateAudioLength($audioLength) {
        $dtF = new \DateTime('@0');
        $dtT = new \DateTime("@$audioLength");
        if ($audioLength > 3600) {
            $audioLength = $dtF->diff($dtT)->format('%h:%i:%s');
        } else {
            $audioLength = $dtF->diff($dtT)->format('%i:%s');
        }

        return $audioLength;
    }
}
