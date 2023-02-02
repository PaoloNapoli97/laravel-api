@extends('layouts.admin')

@section('content')
    <h1>Modifica progetto: {{ $project->title }}</h1>
    <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Titolo</label>
            <input type="title" class="form-control" id="title" name="title" value="{{ old('title', $project->title)}}">
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" id="content" name="content" rows="3" placeholder="Inserisci Il Progetto">{{ old('content', $project->content) }}</textarea>
        </div>
        <div class="mb-3">
            <label for="cover_image" class="form-label">Cover Immagine</label>
            <div>
                <img id="output" width="100" @if($project->cover_image) src="{{ asset("storage/$project->cover_image") }} @endif"/>
                <script>
                    //esempio samu preso da stackoverflow
                    var loadFile = function(event) {
                        var reader = new FileReader();
                        reader.onload = function(){
                            var output = document.getElementById('output');
                            output.src = reader.result;
                            };
                            reader.readAsDataURL(event.target.files[0]);
                    };
                </script>
            </div>
            <input type="file" class="form-control" id="cover_image" name="cover_image" onchange="loadFile(event)">
        </div>
        <div class="mb-2">
            @foreach ($technologies as $technology)
                
            <div class="form-check form-check-inline">

                @if ( $errors->any() )                    
                    <input class="form-check-input" type="checkbox" id="{{ $technology->slug}}" name="technology[]" value="{{ $technology->id}}" {{ in_array($technology->id, old('technologies', [] )) ? 'checked' : ''}}>
                @else
                    <input class="form-check-input" type="checkbox" id="{{ $technology->slug}}" name="technology[]" value="{{ $technology->id}}" {{ $project->technologies->contains($technology->id) ? 'checked' : ''}}>
                @endif
                    <label class="form-check-label" for="{{ $technology->slug}}">{{ $technology->typology}}</label>
            </div>

            @endforeach
        </div>
        <button type="submit" class="btn btn-primary">Modifica</button>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </form>
@endsection