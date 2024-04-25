<?php

namespace App\Entities;

class SpotifySong
{
    public string $name;
    public string $id;
    public string $href;
    public function __construct(string $name, string $id, string $href)
    {
        $this->name = $name;
        $this->href = $href;
        $this->id = $id;
    }
}
