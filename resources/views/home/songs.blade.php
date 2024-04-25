@extends('template.app')

@section('content')
    <form id="create_playlist_form" action="{{route('createPlaylist')}}" method="post" class="form-group">
        @csrf
        @method('post')
        <input type="hidden" name="token" value="{{$token}}">
        <label for="name" class="form-label">Name: </label>
        <input type="text" name="name" class="form-control" placeholder="Name of the playlist">

        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" rows="3" name="description" placeholder="Enter the description..."></textarea>

        @foreach($tracks as $track)
            <input type="checkbox" class="form-check-input" name="tracks_ids[]" value="{{$track->id}}" checked>
            <label for="tracks_ids[]" class="form-check-label">{{$track->name}}</label>
        @endforeach
        <button type="submit" class="btn btn-primary">Create playlist!</button>
    </form>

    <div class="overlay" id="overlay"></div>
    <div class="spinner" id="spinner">
        <div class="lds-dual-ring"></div>
    </div>

    <script>
        document.getElementById('create_playlist_form').addEventListener('submit', function () {
            // Mostrar o overlay e o spinner
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('spinner').style.display = 'block';
        });

        window.addEventListener('load', function () {
            // Ocultar o overlay e o spinner quando a página for totalmente carregada
            document.getElementById('overlay').style.display = 'none';
            document.getElementById('spinner').style.display = 'none';
        });
    </script>

@endsection
