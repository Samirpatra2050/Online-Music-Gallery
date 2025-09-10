<?php

namespace App\Http\Controllers;

use App\Models\Music;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredMusic = Music::active()->featured()->limit(6)->get();
        $latestMusic = Music::active()->latest()->limit(8)->get();
        $categories = Category::where('is_active', true)->get();
        
        return view('home', compact('featuredMusic', 'latestMusic', 'categories'));
    }

    public function browse(Request $request)
    {
        $query = Music::active();
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('artist', 'like', "%{$search}%")
                  ->orWhere('album', 'like', "%{$search}%");
            });
        }
        
        if ($request->has('genre') && $request->genre != '') {
            $query->where('genre', $request->genre);
        }
        
        $music = $query->paginate(12);
        $genres = Music::select('genre')->distinct()->pluck('genre');
        
        return view('browse', compact('music', 'genres'));
    }
}