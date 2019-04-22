<?php

namespace ConCast\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class CalculateTime extends Controller
{
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
