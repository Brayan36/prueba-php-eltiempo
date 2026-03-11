@extends('el-tiempo.app')

@section('content')

    {{-- Filtro por sección --}}
    <nav>
        <a href="{{ route('news.index') }}">All</a>
        @foreach ($sections as $section)
            <a href="{{ route('news.index', ['section' => $section->slug]) }}">
                {{ $section->name }}
            </a>
        @endforeach
    </nav>

    {{-- Listado de noticias --}}
    @forelse ($news as $article)
        <article>
            @if ($article->image_url)
                <img src="{{ $article->image_url }}" alt="{{ $article->title }}">
            @endif

            <span>{{ $article->section->name }}</span>
            <h2>
                <a href="{{ route('news.show', $article->slug) }}">{{ $article->title }}</a>
            </h2>
            <p>{{ Str::limit($article->content, 120) }}</p>

            <footer>
                <span>{{ $article->user->name }}</span>
                <time datetime="{{ $article->published_at->toDateString() }}">
                    {{ $article->published_at->format('d M Y') }}
                </time>
            </footer>
        </article>
    @empty
        <p>No news available.</p>
    @endforelse

    {{-- Paginación --}}
    {{ $news->appends(request()->query())->links() }}

@endsection
