<?php

namespace App\Interfaces;

interface YoutubeServiceInterface
{
    public function getSongs(string $url) : array|null;
}
