<?php

namespace App\Interfaces;

interface SpotifyServiceInterface
{
    public function getTracks(array $ytItems, string $token) : array;
    public function createPlaylist(string $token, string $name, string $description, array $tracks):string;
}
