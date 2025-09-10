<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <!-- Brand (Logo / App Name) -->
                <a class="navbar-brand" href="{{ route('home') }}">
                    {{ config('app.name', 'Online Music Gallery') }}
                </a>

                <!-- Toggle Button for Mobile -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" 
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/dashboard') }}">Music</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/contact') }}">Contact Us</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/about') }}">About Us</a></li>
                    </ul>

                    <!-- Right Side Navbar -->
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if(Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                                </li>
                            @endif
                            @if(Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown d-flex align-items-center">
                                <!-- Avatar -->
                                <img src="{{ Auth::user()->avatar ?? asset('image/default-cover.jpg') }}" 
                                     alt="User Avatar" style="width:35px; height:35px; border-radius:50%; margin-right:8px;">

                                <!-- Dropdown -->
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" 
                                   data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </a>

                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    @if(Auth::user()->role === 'admin')
                                        <li>
                                            <a class="dropdown-item" href="{{ url('/admin') }}">
                                                Admin Panel
                                            </a>
                                        </li>
                                    @endif
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                           Logout
                                        </a>
                                    </li>
                                </ul>

                                <!-- Logout Form -->
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="py-4">
            @yield('content') <!-- Each page will inject its content here -->
        </main>
    </div>
</body>
</html>
