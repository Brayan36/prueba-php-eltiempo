@extends('el-tiempo.app')

@section('content')

    {{-- Noticia principal --}}
    <article>
        <span>{{ $article->section->name }}</span>
        <h1>{{ $article->title }}</h1>

        <div>
            <span>{{ $article->user->name }}</span>
            @if(is_null($article->published_at))
                'No publicado.'
            @else
                <time datetime="{{ $article->published_at->toDateString() }}">
                    {{ $article->published_at->format('d M Y') }}
                </time>
            @endif

        </div>

        @if ($article->image_url)
            <img src="{{ $article->image_url }}" alt="{{ $article->title }}">
        @endif

        <div>
            {!! nl2br(e($article->content)) !!}
        </div>
    </article>

    {{-- Noticias relacionadas --}}
    @if ($related->isNotEmpty())
        <section>
            <h3>Related news</h3>

            @foreach ($related as $item)
                <article>
                    @if ($item->image_url)
                        <img src="{{ $item->image_url }}" alt="{{ $item->title }}">
                    @endif

                    <h4>
                        <a href="{{ route('news.show', $item->slug) }}">{{ $item->title }}</a>
                    </h4>
                    <time datetime="{{ $item->published_at->toDateString() }}">
                        {{ $item->published_at->format('d M Y') }}
                    </time>
                </article>
            @endforeach
        </section>
    @endif

@endsection
