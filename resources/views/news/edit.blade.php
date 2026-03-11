@extends('el-tiempo.app')

@section('title', 'Editar articulo')

@section('content')

    <div class="form-page-header">
        <h1 class="form-page-title">Editar Articulo</h1>
        <a href="{{ route('dashboard.my-news') }}" class="form-back">Regresar</a>
    </div>

    <div class="form-card">
        <form action="{{ route('dashboard.news.update', $news) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('news.form')

            <div class="form-footer">
                <a href="{{ route('news.show', $news->slug) }}" class="btn--cancel">Cancelar</a>
                <button type="submit" class="btn--save">Actualizar</button>
            </div>
        </form>
    </div>

@endsection
