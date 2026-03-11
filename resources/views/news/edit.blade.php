@extends('el-tiempo.app')

@section('content')

    <h1>Edit article</h1>

    <form action="{{ route('dashboard.news.update', $news) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('news.form')
    </form>

@endsection
