@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Add New Music 🎵</h2>

    <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="mb-3">
            <label>Artist</label>
            <input type="text" name="artist" class="form-control" value="{{ old('artist') }}" required>
        </div>

        <div class="mb-3">
            <label>Album</label>
            <input type="text" name="album" class="form-control" value="{{ old('album') }}">
        </div>

        <div class="mb-3">
            <label>Genre</label>
            <input type="text" name="genre" class="form-control" value="{{ old('genre') }}">
        </div>

        <div class="mb-3">
            <label>Duration (seconds)</label>
            <input type="number" name="duration" class="form-control" value="{{ old('duration') }}">
        </div>

        <div class="mb-3">
            <label>Cover Image</label>
            <input type="file" name="cover_image" class="form-control" accept="image/*" required>
        </div>

        <div class="mb-3">
            <label>Music File</label>
            <input type="file" name="file_path" class="form-control" accept=".mp3,.wav" required>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label>Release Date</label>
            <input type="date" name="release_date" class="form-control" value="{{ old('release_date') }}">
        </div>

        <div class="form-check mb-3">
            <input type="hidden" name="is_featured" value="0">
            <input type="checkbox" name="is_featured" class="form-check-input" value="1" id="is_featured">
            <label class="form-check-label" for="is_featured">Featured</label>
        </div>

        <div class="form-check mb-3">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" class="form-check-input" value="1" id="is_active" checked>
            <label class="form-check-label" for="is_active">Active</label>
        </div>

        <button type="submit" class="btn btn-primary">Add Music</button>
        <a href="{{ route('admin.panel') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection