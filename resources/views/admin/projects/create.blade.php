@extends('layouts.admin')

@section('content')
    <h1>Crea un Progetto</h1>
    <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Titolo</label>
            <input type="title" class="form-control" id="title" name="title">
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" id="content" name="content" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="cover_image" class="form-label">Cover Immagine</label>
            <div>
                <img id="output" width="100"/>
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
        <div class="mb-3">
            <label for="type_id" class="form-label">Tipologia</label>
            <select class="form-select" name="type_id" id="type_id">
                <option value="">Nessuna Tipologia</option>
                @foreach ($types as $type)
                    <option value="{{ $type->id }}" {{old('type_id') == $type->id ? 'selected' : ''}}>{{$type->develop}}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-2">
            @foreach ($technologies as $technology)
                
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="{{ $technology->slug}}" name="technology[]" value="{{ $technology->id}}">
                <label class="form-check-label" for="{{ $technology->slug}}">{{ $technology->typology}}</label>
            </div>

            @endforeach
        </div>
            <button type="submit" class="btn btn-primary">Crea Progetto</button>
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