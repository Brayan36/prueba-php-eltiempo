@extends('el-tiempo.app')

@section('content')

    <div>
        <h1>My news</h1>
        <a href="{{ route('dashboard.news.create') }}">+ New article</a>
    </div>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <table>
        <thead>
        <tr>
            <th>Title</th>
            <th>Section</th>
            <th>Status</th>
            <th>Published at</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($news as $article)
            <tr>
                <td>{{ $article->title }}</td>
                <td>{{ $article->section->name }}</td>
                <td>{{ $article->status->name }}</td>
                <td>{{ $article->published_at?->format('d M Y') ?? '—' }}</td>
                <td>
                    <a href="{{ route('news.show', $article->slug) }}">View</a>
                    <a href="{{ route('dashboard.news.edit', $article) }}">Edit</a>

                    <form action="{{ route('dashboard.news.destroy', $article) }}" method="POST"
                          onsubmit="return confirm('Delete this article?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">No articles yet.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{ $news->links() }}

@endsection
