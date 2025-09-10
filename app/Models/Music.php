<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    use HasFactory;

    // Specify the table name explicitly
    protected $table = 'music';

    protected $fillable = [
        'title', 'artist', 'album', 'genre', 'duration',
        'file_path', 'cover_image', 'description', 'release_date',
        'is_featured', 'is_active', 'play_count', 'uploaded_by'
    ];

    protected $casts = [
        'release_date' => 'date',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Accessors
    public function getFormattedDurationAttribute()
    {
        if (!$this->duration) return 'Unknown';
        $minutes = floor($this->duration / 60);
        $seconds = $this->duration % 60;
        return sprintf('%d:%02d', $minutes, $seconds);
    }

public function getCoverUrlAttribute()
{
    if ($this->cover_image) {
        // cover_image already contains path like "covers/hashedname.jpg"
        return asset('storage/' . $this->cover_image);
    }
    return asset('images/default-cover.jpg');
}

public function getMusicUrlAttribute()
{
    if ($this->file_path) {
        // file_path already contains path like "music/hashedname.mp3"
        return asset('storage/' . $this->file_path);
    }
    return null;
}
}
