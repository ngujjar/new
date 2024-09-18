<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use getID3;

class AudioController extends Controller
{
    public function getAudioPlaytime(Request $request)
    {
        $request->validate([
            'audio' => 'required|file|mimes:mp3,wav,aac,flac,ogg,m4a|max:20000',
        ]);

        $file = $request->file('audio');
        $filePath = $file->getPathname();

        $getID3 = new getID3;
        $fileInfo = $getID3->analyze($filePath);

        if (isset($fileInfo['playtime_seconds'])) {
            $playTimeSeconds = $fileInfo['playtime_seconds'];
            $playTimeFormatted = gmdate("H:i:s", $playTimeSeconds); 

            return response()->json([
                'status' => 'success',
                'playtime' => $playTimeFormatted,
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Could not retrieve playtime information.',
            ]);
        }
    }
}
