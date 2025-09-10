@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>About Us</h2>
    <p>Welcome to <strong>{{ config('app.name', 'My Music App') }}</strong>! 🎶</p>

    <p>
        Our platform is designed for music lovers to explore, play, and enjoy their favorite tracks anytime, anywhere.
        Users can create playlists, upload music, and discover new songs through an intuitive and interactive interface.
    </p>

    <h4>Features:</h4>
    <ul>
        <li>User authentication with secure login and registration.</li>
        <li>Personalized dashboard showing uploaded and favorite music.</li>
        <li>Interactive music cards with play buttons.</li>
        <li>Floating music player bar to play one song at a time across the site.</li>
        <li>Responsive design for desktop and mobile devices.</li>
    </ul>

    <h4>Our Mission:</h4>
    <p>
        We aim to create a seamless and enjoyable experience for music enthusiasts,
        enabling them to connect with music in a simple and beautiful way.
    </p>

    <h4>Contact Us:</h4>
    <p>
        For questions or support, feel free to reach out through the Contact page.
    </p>
</div>
@endsection
