<?php

namespace App\Services;

use App\Entities\SpotifySong;
use App\Entities\YoutubeItem;
use App\Interfaces\SpotifyServiceInterface;

class SpotifyService implements SpotifyServiceInterface
{

    public function getTracks(array $ytItems, string $token): array
    {
        $tracks = [];
        foreach($ytItems as $item){

            $tracks[] = $this->searchTrack($item->title.' '.$item->artist,$token);
        }
        return $tracks;
    }

    public function createPlaylist(string $token, string $name, string $description, array $tracks): string
    {
        $userId = $this->getUserId($token);
        $url = "https://api.spotify.com/v1/users/$userId/playlists";

        $body = [
            'name'=>$name,
            'description'=>$description
        ];

        $header = [
            'Content-Type: application/json',
            'Authorization: Bearer '.$token
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
        curl_setopt($ch,CURLOPT_POST,true);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($body));

        $response = json_decode(curl_exec($ch),true);
        curl_close($ch);

        $playlistId = $response['id'];

        $this->addSongsToPlaylist($playlistId,$tracks,$token);

        return $playlistId;
    }

    private function getUserId($token) : string {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,'https://api.spotify.com/v1/me');
        curl_setopt($ch,CURLOPT_HTTPHEADER,['Authorization: Bearer '.$token]);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

        $response = json_decode(curl_exec($ch),true);
        curl_close($ch);

        $id = $response['id'];

        return $id;
    }

    private function searchTrack(string $search, string $token) : SpotifySong{
        $baseUrl = 'https://api.spotify.com/v1/search';
        $query = [
            'q'=>$search,
            'type'=>'track'
        ];
        $url = $baseUrl.'?'.http_build_query($query);
        $headers = array('Authorization: Bearer '.$token);
        $ch = curl_init();

        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);

        $response = curl_exec($ch);

        curl_close($ch);

        $data = json_decode($response,true);
        $name = $data['tracks']['items'][0]['name'];
        $href = $data['tracks']['items'][0]['href'];
        $id = $data['tracks']['items'][0]['id'];

        return new SpotifySong($name, $id, $href);
    }
    private function addSongsToPlaylist(string $playlistId, array $tracksIds, string $token) : void{
        $url = "https://api.spotify.com/v1/playlists/$playlistId/tracks";

        $uris = [];
        foreach($tracksIds as $trackId){
            $uris[] = "spotify:track:".$trackId;
        }

        $body = json_encode(['uris'=>$uris]);
        $header =[
            'Content-Type: application/json',
            'Authorization: Bearer '.$token
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
        curl_setopt($ch,CURLOPT_POST,true);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$body);

        $response = json_decode(curl_exec($ch),true);
        curl_close($ch);
    }


}
