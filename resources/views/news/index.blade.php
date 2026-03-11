@extends('el-tiempo.app')

@section('title', 'Latest news')

@section('content')

    @if ($news->isNotEmpty())
        @php $hero = $news->first() @endphp

        <a href="{{ route('news.show', $hero->slug) }}">
            <div class="hero-card">
                <div class="hero-card__body">
                    <div>
                        <span class="section-tag">{{ $hero->section->name }}</span>
                        <h2 class="news-title hero-card__title">{{ $hero->title }}</h2>
                        <p class="hero-card__excerpt">{{ Str::limit(strip_tags($hero->content), 180) }}</p>
                    </div>
                    <p class="news-meta">
                        <strong>{{ $hero->user->name }}</strong>
                        &ndash; {{ $hero->published_at->format('d M Y') }}
                    </p>
                </div>
                <div class="hero-card__img">
                    @if ($hero->image_url)
                        <img src="{{ $hero->image_url }}" alt="{{ $hero->title }}">
                    @endif
                </div>
            </div>
        </a>
    @endif

    {{-- contenedor de articulos--}}
    <div class="news-grid">
        @foreach ($news->skip(1) as $article)
            <a href="{{ route('news.show', $article->slug) }}">
                <div class="card">
                    <div class="card-img">
                        @if ($article->image_url)
                            <img src="{{ $article->image_url }}" alt="{{ $article->title }}">
                        @endif
                    </div>
                    <div class="card-body">
                        <span class="section-tag">{{ $article->section->name }}</span>
                        <h3 class="news-title card-title">{{ $article->title }}</h3>
                        <p class="news-meta">
                            <strong>{{ $article->user->name }}</strong>
                            &ndash; {{ $article->published_at->format('d M Y') }}
                        </p>
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    {{-- paginación--}}
    <div class="pagination-wrapper">
        {{ $news->appends(request()->query())->links() }}
    </div>

@endsection
