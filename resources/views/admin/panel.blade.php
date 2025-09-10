@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Admin Panel 🎵</h2>

    <a href="{{ route('admin.music.create') }}" class="btn btn-success mb-3">Add New Music</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Cover</th>
                <th>Title</th>
                <th>Artist</th>
                <th>Album</th>
                <th>Genre</th>
                <th>Duration</th>
                <th>Active</th>
                <th>Featured</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($music as $track)
            <tr>
                <td><img src="{{ asset('storage/'.$track->cover_image) }}" width="80" height="80" style="object-fit:cover;"></td>
                <td>{{ $track->title }}</td>
                <td>{{ $track->artist }}</td>
                <td>{{ $track->album ?? '-' }}</td>
                <td>{{ $track->genre ?? '-' }}</td>
                <td>{{ $track->formatted_duration ?? '-' }}</td>
                <td>{{ $track->is_active ? 'Yes' : 'No' }}</td>
                <td>{{ $track->is_featured ? 'Yes' : 'No' }}</td>
                <td>
                    <a href="{{ route('admin.music.edit', $track->id) }}" class="btn btn-sm btn-warning mb-1">Edit</a>
                    <form action="{{ route('admin.music.destroy', $track->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this music?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
