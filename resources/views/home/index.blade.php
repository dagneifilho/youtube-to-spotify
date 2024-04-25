@extends('template.app')

@section('content')
    <form id="youtube_form" action="{{route('getSongs')}}" class="form-group" method="GET">
        @method('get')
        @csrf
        <div class="row g-3 align-items-center">
            <div class="col-auto">
                <label for="playlist_url" class='col-form-label'>Playlist Url: </label>
            </div>
            <div class="col-auto">
                <input type="text" class="form-control" name='playlist_url' placeholder="https://youtube.com/...">
            </div>
            <input type="hidden" name="token" value={{$token}}>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Get Songs!</button>
            </div>
        </div>

    </form>


    <div class="overlay" id="overlay"></div>
    <div class="spinner" id="spinner">
        <div class="lds-dual-ring"></div>
    </div>

    <script>
        document.getElementById('youtube_form').addEventListener('submit', function () {
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
