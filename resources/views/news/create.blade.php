@extends('el-tiempo.app')

@section('content')

    <h1>New article</h1>

    <form action="{{ route('dashboard.news.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('news.form')
    </form>

@endsection
