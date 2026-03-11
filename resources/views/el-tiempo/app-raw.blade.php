<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name'))</title>
    <meta name="description" content="@yield('meta_description', '')">

    {{-- CSS propio --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- Slot para CSS adicional por vista --}}
    @stack('styles')
</head>
<body>

<header id="site-header">
    <div id="site-logo">
        <a href="{{ route('home') }}">{{ config('app.name') }}</a>
    </div>

    {{-- Navegación por secciones --}}
    <nav id="site-nav">
        @foreach (\App\Models\Section::all() as $section)
            <a href="{{ route('news.index', ['section' => $section->slug]) }}">
                {{ $section->name }}
            </a>
        @endforeach
    </nav>

    {{-- Autenticación --}}
    <div id="site-auth">
        @auth
            <span>{{ auth()->user()->name }}</span>
            <a href="{{ route('dashboard.my-news') }}">My news</a>
            <a href="{{ route('dashboard.news.create') }}">+ New article</a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Register</a>
        @endauth
    </div>
</header>

<main id="site-main">

    {{-- Flash messages --}}
    @if (session('success'))
        <div class="flash flash--success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="flash flash--error">{{ session('error') }}</div>
    @endif

    @yield('content')

</main>

<footer id="site-footer">
    <p>&copy; {{ date('Y') }} {{ config('app.name') }}</p>
</footer>

{{-- JS  --}}
<script src="{{ asset('js/app.js') }}"></script>

@stack('scripts')

</body>
</html>
