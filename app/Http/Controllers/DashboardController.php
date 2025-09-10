<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Music;

class DashboardController extends Controller
{
    public function index()
{
    // Fetch all music grouped by genre
    $musicByGenre = \App\Models\Music::orderBy('genre')
                    ->get()
                    ->groupBy('genre');

    return view('dashboard', compact('musicByGenre'));
}
}
