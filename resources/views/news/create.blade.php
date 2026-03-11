@extends('el-tiempo.app')

@section('title', 'Nuevo Articulo')

@section('content')

    <div class="form-page-header">
        <h1 class="form-page-title">Nuevo Articulo</h1>
        <a href="{{ route('dashboard.my-news') }}" class="form-back">Regresar</a>
    </div>

    <div class="form-card">
        <form action="{{ route('dashboard.news.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @include('news.form')

            <div class="form-footer">
                <a href="{{ route('dashboard.my-news') }}" class="btn--cancel">Cancelar</a>
                <button type="submit" class="btn--save">Guardar</button>
            </div>
        </form>
    </div>

@endsection
