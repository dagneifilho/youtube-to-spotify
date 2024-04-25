<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        $client_id = config('external.spotify_client_id');
        $redirectUrl = route('callback');
        $scope = 'user-read-private user-read-email playlist-modify-public playlist-modify-private';

        $loginUrl = 'https://accounts.spotify.com/authorize?';

        $query = http_build_query([
           'response_type'=>'code',
            'show_dialog'=>true,
            'client_id'=>$client_id,
            'scope'=>$scope,
            'redirect_uri'=>$redirectUrl
        ]);
        return redirect($loginUrl.$query);
    }
    public function callback(Request $request){
        $code  = $request->get('code');
        $client_id = config('external.spotify_client_id');
        $clientSecret = config('external.spotify_client_secret');
        $authorization = base64_encode($client_id.':'.$clientSecret);
        $uri = 'https://accounts.spotify.com/api/token';
        if(!$code)
            return redirect(route('login'));

        $post = [
            'code'=>$code,
            'redirect_uri'=>route('callback'),
            'grant_type'=>'authorization_code',
        ];
        $headers = array('Content-Type: application/x-www-form-urlencoded',
            'Authorization: Basic '.$authorization);



        $ch = curl_init();
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($post));
        curl_setopt($ch,CURLOPT_URL,$uri);

        $result = json_decode(curl_exec($ch),true);
        curl_close($ch);
        $token = $result['access_token'];
        if(!$token)
            redirect(route('index'));
        return redirect(route('index',['token'=>$token]));
    }
}
