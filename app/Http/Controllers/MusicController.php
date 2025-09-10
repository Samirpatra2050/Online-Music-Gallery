<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Music;

class MusicController extends Controller
{
    public function incrementPlay($id)
    {
        $music = Music::findOrFail($id);
        $music->increment('play_count');
        return response()->json(['success' => true, 'play_count' => $music->play_count]);
    }
}
