@extends('el-tiempo.app')

@section('title', 'Mis articulos')

@section('content')

    {{-- Cabecera con enlaces para crear nuevos articulos --}}
    <div class="dashboard-header">
        <div>
            <h1 class="dashboard-title">Mis articulos</h1>
            <p class="dashboard-sub">{{ $news->total() }} {{ Str::plural('article', $news->total()) }} total</p>
        </div>
        <a href="{{ route('dashboard.news.create') }}" class="btn btn--primary">+ Nuevo Articulo</a>
    </div>

    {{-- Tabla con listado de articulos --}}
    <div class="table-wrapper">
        <table class="dashboard-table">
            <thead>
            <tr>
                <th>Tilulo</th>
                <th>Sección</th>
                <th>estado</th>
                <th>Publicado</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($news as $article)
                <tr>
                    <td class="td-title">
                        {{ Str::limit($article->title, 60) }}
                    </td>
                    <td>
                        <span class="section-tag">{{ $article->section->name }}</span>
                    </td>
                    <td>
                            <span class="status-badge status-badge--{{ $article->status->slug }}">
                                {{ $article->status->name }}
                            </span>
                    </td>
                    <td class="td-date">
                        {{ $article->published_at?->format('d M Y') ?? '—' }}
                    </td>
                    <td class="td-actions">
                        <a href="{{ route('news.show', $article->slug) }}" class="btn-action btn-action--view">
                            View
                        </a>
                        <a href="{{ route('dashboard.news.edit', $article) }}" class="btn-action btn-action--edit">
                            Edit
                        </a>
                        <form action="{{ route('dashboard.news.destroy', $article) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this article?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action btn-action--delete">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="td-empty">
                        No hay articulos publicados. <a href="{{ route('dashboard.news.create') }}">Crear un articulo</a>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    <div class="pagination-wrapper">
        {{ $news->links() }}
    </div>

@endsection

@push('styles')
    <style>
        .dashboard-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .dashboard-title {
            font-family: var(--font-display);
            font-size: 28px;
            font-weight: 800;
            text-transform: uppercase;
            color: var(--black);
        }

        .dashboard-sub {
            font-size: 13px;
            color: var(--gray-mid);
            margin-top: 2px;
        }

        .btn--primary {
            background: var(--red);
            color: var(--white);
            font-family: var(--font-display);
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 10px 20px;
            transition: background .2s;
            white-space: nowrap;
        }

        .btn--primary:hover {
            background: var(--red-dark);
            color: var(--white);
        }

        .table-wrapper {
            background: var(--white);
            overflow-x: auto;
        }

        .dashboard-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .dashboard-table thead {
            background: var(--black);
            color: var(--white);
        }

        .dashboard-table thead th {
            padding: 13px 16px;
            text-align: left;
            font-family: var(--font-display);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .dashboard-table tbody tr {
            border-bottom: 1px solid var(--gray-light);
            transition: background .15s;
        }

        .dashboard-table tbody tr:hover {
            background: #fafafa;
        }

        .dashboard-table tbody tr:last-child {
            border-bottom: none;
        }

        .dashboard-table td {
            padding: 14px 16px;
            vertical-align: middle;
        }

        .td-title {
            font-weight: 600;
            color: var(--black);
            max-width: 320px;
        }

        .td-date {
            white-space: nowrap;
            color: var(--gray-mid);
            font-size: 13px;
        }

        .td-empty {
            text-align: center;
            padding: 40px 16px;
            color: var(--gray-mid);
        }

        .td-empty a {
            color: var(--red);
            font-weight: 600;
        }

        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .8px;
            text-transform: uppercase;
            border-radius: 2px;
        }

        .status-badge--published {
            background: #edfaf1;
            color: #1e8449;
        }

        .status-badge--draft {
            background: #fef9e7;
            color: #b7950b;
        }

        .status-badge--archived {
            background: #f4f4f4;
            color: #777;
        }

        .td-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
        }

        .btn-action {
            display: inline-block;
            padding: 5px 12px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .5px;
            text-transform: uppercase;
            border: none;
            cursor: pointer;
            font-family: inherit;
            transition: opacity .2s;
        }

        .btn-action:hover {
            opacity: .75;
        }

        .btn-action--view {
            background: var(--gray-light);
            color: var(--black);
        }

        .btn-action--edit {
            background: var(--black);
            color: var(--white);
        }

        .btn-action--delete {
            background: var(--red);
            color: var(--white);
        }
    </style>
@endpush

