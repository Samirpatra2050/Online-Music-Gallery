<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Music;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // Show all music
    public function index()
    {
        $music = Music::all();
        return view('admin.panel', compact('music'));
    }

    // Show create music form
    public function create()
    {
        return view('admin.create');
    }

    // Store new music
    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'artist'       => 'required|string|max:255',
            'album'        => 'nullable|string|max:255',
            'genre'        => 'nullable|string|max:100',
            'duration'     => 'nullable|integer',
            'cover_image'  => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'file_path'    => 'required|mimes:mp3,wav|max:10240',
            'description'  => 'nullable|string',
            'release_date' => 'nullable|date',
            'is_featured'  => 'nullable',
            'is_active'    => 'nullable',
        ]);

        try {
            // ✅ Debug: log incoming request
            \Log::info('Music create request:', $request->all());

            $coverPath = $request->file('cover_image')->store('covers', 'public');
            $filePath  = $request->file('file_path')->store('music', 'public');

            $music = Music::create([
                'title'        => $request->title,
                'artist'       => $request->artist,
                'album'        => $request->album,
                'genre'        => $request->genre,
                'duration'     => $request->duration,
                'cover_image'  => $coverPath,
                'file_path'    => $filePath,
                'description'  => $request->description,
                'release_date' => $request->release_date,
                'is_featured'  => $request->has('is_featured'), // true if checkbox checked
                'is_active'    => $request->has('is_active'),   // true if checkbox checked
            ]);

            // ✅ Debug: confirm saved
            \Log::info('Music saved successfully:', $music->toArray());

            return redirect()->route('admin.panel')->with('success', 'Music added successfully!');
        } catch (\Exception $e) {
            // Show exact error message on screen
            dd('Error saving music:', $e->getMessage(), $e->getTraceAsString());
        }
    }

    // Show edit form
    public function edit($id)
    {
        $track = Music::findOrFail($id);
        return view('admin.edit', compact('track'));
    }

    // Update music
    public function update(Request $request, $id)
    {
        $track = Music::findOrFail($id);

        $request->validate([
            'title'        => 'required|string|max:255',
            'artist'       => 'required|string|max:255',
            'album'        => 'nullable|string|max:255',
            'genre'        => 'nullable|string|max:100',
            'duration'     => 'nullable|integer',
            'cover_image'  => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'file_path'    => 'nullable|mimes:mp3,wav|max:10240',
            'description'  => 'nullable|string',
            'release_date' => 'nullable|date',
            'is_featured'  => 'nullable',
            'is_active'    => 'nullable',
        ]);

        try {
            $data = $request->only([
                'title', 'artist', 'album', 'genre', 'duration',
                'description', 'release_date'
            ]);

            // Handle cover update
            if ($request->hasFile('cover_image')) {
                if ($track->cover_image) {
                    Storage::disk('public')->delete($track->cover_image);
                }
                $data['cover_image'] = $request->file('cover_image')->store('covers', 'public');
            }

            // Handle file update
            if ($request->hasFile('file_path')) {
                if ($track->file_path) {
                    Storage::disk('public')->delete($track->file_path);
                }
                $data['file_path'] = $request->file('file_path')->store('music', 'public');
            }

            // Booleans
            $data['is_featured'] = $request->boolean('is_featured');
            $data['is_active']   = $request->boolean('is_active');

            $track->update($data);

            \Log::info('Music updated successfully:', $track->toArray());

            return redirect()->route('admin.panel')->with('success', 'Music updated successfully!');
        } catch (\Exception $e) {
            dd('Error updating music:', $e->getMessage(), $e->getTraceAsString());
        }
    }

    // Delete music
    public function destroy($id)
    {
        try {
            $track = Music::findOrFail($id);

            if ($track->cover_image) {
                Storage::disk('public')->delete($track->cover_image);
            }
            if ($track->file_path) {
                Storage::disk('public')->delete($track->file_path);
            }

            $track->delete();
            \Log::info("Music deleted: ID {$id}");

            return redirect()->route('admin.panel')->with('success', 'Music deleted successfully!');
        } catch (\Exception $e) {
            dd('Error deleting music:', $e->getMessage(), $e->getTraceAsString());
        }
    }
}
