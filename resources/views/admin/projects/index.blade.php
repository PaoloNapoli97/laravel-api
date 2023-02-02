@extends('layouts.admin')

@section('content')
    <h1>Lista Progetti</h1>
    @if(session('message'))
    <div class="alert alert-success">
      {{session('message')}}
    </div>
    @endif
    <table class="table table-striped table-dark">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Titolo</th>
            <th scope="col">Slug</th>
            <th scope="col">Azioni</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
                <tr>
                    <td>{{ $project->id }}</td>
                    <td>{{ $project->title }}</td>
                    <td>{{ $project->slug }}</td>
                    <td>
                      <a href="{{ route('admin.projects.show', $project) }} " class="btn btn-success">Info</a>
                      <a href="{{ route('admin.projects.edit', $project) }} " class="btn btn-warning">Modifica</a>
                      <form action="{{ route('admin.projects.destroy', $project) }}" class="d-inline-block" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">Elimina</button>
                      </form>
                    </td>
                </tr>
            @endforeach

        </tbody>
      </table>
      <div class="m2">
        <a href=" {{ route('admin.projects.create') }} " class="btn btn-secondary">Aggiungi un progetto</a>
      </div>
@endsection