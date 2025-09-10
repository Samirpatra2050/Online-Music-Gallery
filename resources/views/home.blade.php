@extends('layouts.app')

@section('content')
<div class="text-center mt-5">
    <h1>🎵 Online Music Gallery</h1>
    <p>Explore and enjoy your favorite tracks anytime, anywhere.</p>
</div>
@endsection

@push('styles')
<style>
/* Full page background */
body {
    background: url('{{ asset('images/bg1.jpg') }}') no-repeat center center fixed;
    background-size: cover;   /* stretch kore full cover */
    margin: 0;
    height: 100%;
    width: 100%;
}

/* Make navbar transparent */
.navbar,
.navbar.navbar-expand-md,
.navbar.bg-white,
.bg-white {
    background: transparent !important;  /* remove background */
    box-shadow: none !important;        /* remove shadow */
}

/* Overlay (dark layer for readability) */
.overlay {
    background: rgba(0, 0, 0, 0.5); /* semi transparent black */
    min-height: 100vh;              /* at least full screen */
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    text-align: center;
}

/* Title */
.gallery-title {
    font-size: 52px;
    font-weight: 800;
    text-transform: uppercase;
    margin-bottom: 15px;
    color: #fff;
}

/* Subtitle */
.gallery-subtitle {
    font-size: 20px;
    color: #e0e0e0;
}
</style>
@endpush
