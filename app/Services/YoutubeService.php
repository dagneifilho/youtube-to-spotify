<?php

namespace App\Services;

use App\Entities\YoutubeItem;
use App\Interfaces\YoutubeServiceInterface;

class YoutubeService implements YoutubeServiceInterface
{

    public function getSongs(string $url): array|null
    {
        $youtubeKey = config('external.youtube_key');
        $youtubeBaseUrl = config('external.youtube_base_url').'playlistItems';

        $id = $this->getIdFromUrl($url);

        $query = http_build_query([
            'key'=>$youtubeKey,
            'part'=>'snippet',
            'playlistId'=>$id,
            'maxResults'=>50
        ]);
        $url = $youtubeBaseUrl.'?'.$query;

        $ch = curl_init();

        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_SSH_COMPRESSION, true);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $url
        ]);

        $result = curl_exec($ch);
        curl_close($ch);


        $data = json_decode($result,true);

        $items = [];
        foreach ($data['items'] as $item) {
            $items[] = YoutubeItem::fromData($item['snippet']);

        }

        return $items;
    }


    private function getIdFromUrl(string $url) : string{
        $urlComponents = parse_url($url);

        parse_str($urlComponents['query'],$params);
        return $params['list'];
    }
}
