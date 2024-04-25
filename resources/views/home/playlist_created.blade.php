@extends('template.app')

@section('content')

    <div id="success-card">
        <h3>Playlist created successfully!</h3>
        <p>Visit your Spotify account and enjoy!!</p>
        <a href="{{route('index')}}">
            <button class="btn btn-primary">
                Create another playlist!
            </button>
        </a>
    </div>

@endsection
