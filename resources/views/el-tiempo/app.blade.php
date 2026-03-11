<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    <meta name="description" content="@yield('meta_description', '')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700;800;900&family=Barlow:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/motor/app.css') }}">

    @stack('styles')
</head>
<body>

<div id="top-bar">
    @auth
        <a href="{{ route('dashboard.news.create') }}">+ Nuevo articulo</a>
        <a href="{{ route('dashboard.my-news') }}">Mis articulos</a>
    @else
        <a href="{{ route('login') }}">Login</a>
    @endauth
</div>

<header id="site-header">
    <div id="header-inner">

        <button id="menu-toggle" aria-label="Menu">
            <span></span><span></span><span></span>
        </button>

        <div id="site-logo">
            <a href="{{ route('home') }}">{{ config('app.name') }}</a>
        </div>

        <div id="header-auth">
            @auth
                <span id="header-user">{{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            @endauth
        </div>

    </div>
</header>

<nav id="site-nav">
    <ul>
        <li>
            <a href="{{ route('home') }}" {{ request()->routeIs('home') ? 'class=active' : '' }}>
                Home
            </a>
        </li>
{{-- Emulando navbar con las sessiones  --}}
        @foreach (\App\Models\Section::all() as $section)
            <li>
                <a href="{{ route('news.index', ['section' => $section->slug]) }}"
                    {{ request('section') === $section->slug ? 'class=active' : '' }}>
                    {{ $section->name }}
                </a>
            </li>
        @endforeach
    </ul>
</nav>

{{-- Contenido principal --}}
<main id="site-main">

{{--  mostramos mensajes de error o exito  --}}
    @if (session('success'))
        <div class="flash flash--success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="flash flash--error">{{ session('error') }}</div>
    @endif

{{--  Contenidos y formularios  --}}
    @yield('content')

</main>

<footer id="site-footer">
    <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
</footer>

@stack('scripts')

</body>
</html>
