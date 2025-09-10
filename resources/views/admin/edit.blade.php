@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Music 🎵</h2>

    <form action="{{ route('admin.music.update', $track->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="{{ $track->title }}" required>
        </div>

        <div class="mb-3">
            <label>Artist</label>
            <input type="text" name="artist" class="form-control" value="{{ $track->artist }}" required>
        </div>

        <div class="mb-3">
            <label>Album</label>
            <input type="text" name="album" class="form-control" value="{{ $track->album }}">
        </div>

        <div class="mb-3">
            <label>Genre</label>
            <input type="text" name="genre" class="form-control" value="{{ $track->genre }}">
        </div>

        <div class="mb-3">
            <label>Duration (seconds)</label>
            <input type="number" name="duration" class="form-control" value="{{ $track->duration }}">
        </div>

        <div class="mb-3">
            <label>Cover Image</label>
            <input type="file" name="cover_image" class="form-control" accept="image/*">
            @if($track->cover_image)
                <img src="{{ asset('storage/'.$track->cover_image) }}" width="100" class="mt-2">
            @endif
        </div>

        <div class="mb-3">
            <label>Music File</label>
            <input type="file" name="file_path" class="form-control" accept=".mp3,.wav">
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ $track->description }}</textarea>
        </div>

        <div class="mb-3">
            <label>Release Date</label>
            <input type="date" name="release_date" class="form-control" value="{{ $track->release_date?->format('Y-m-d') }}">
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="is_featured" class="form-check-input" id="is_featured" {{ $track->is_featured ? 'checked' : '' }}>
            <label class="form-check-label" for="is_featured">Featured</label>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="is_active" class="form-check-input" id="is_active" {{ $track->is_active ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Active</label>
        </div>

        <button type="submit" class="btn btn-primary">Update Music</button>
        <a href="{{ route('admin.panel') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
