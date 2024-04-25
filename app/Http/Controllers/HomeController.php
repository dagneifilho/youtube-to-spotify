<?php

namespace App\Http\Controllers;

use App\Interfaces\SpotifyServiceInterface;
use App\Interfaces\YoutubeServiceInterface;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected YoutubeServiceInterface $ytService;
    protected  SpotifyServiceInterface $spotifyService;
    public function __construct(YoutubeServiceInterface $ytService, SpotifyServiceInterface $spotifyService) {
        $this->ytService = $ytService;
        $this->spotifyService = $spotifyService;
    }

    public function index(Request $request){
        $token = $request->get('token');
        if(!$token)
            return redirect(route('login'));
        return view('home.index')->with('token',$token);
    }

    public function getSongs(Request $request) {
        $token = $request->get('token');

        $ytPlaylistUrl = $request->get('playlist_url');
        $ytItems = $this->ytService->getSongs($ytPlaylistUrl);

        $tracks = $this->spotifyService->getTracks($ytItems,$token);


        return view('home.songs')->with(['tracks'=>$tracks,'token'=>$token]);
    }
    public function createPlaylist(Request $request){

        $token = $request->get('token');
        $name = $request->get('name');
        $description = $request->get('description');
        $tracks = $request->get('tracks_ids');

        $playlist = $this->spotifyService->createPlaylist($token,$name,$description,$tracks);

        return view('home.playlist_created');
    }
}
