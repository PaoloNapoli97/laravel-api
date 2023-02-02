@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>{{ $project->title }}</h1>
        <div>{{ $project->content }}</div>
        @if ( $project->cover_image)
            <img class="w-100" src="{{ asset("storage/$project->cover_image") }}" alt="">
        @endif
    </div>
@endsection