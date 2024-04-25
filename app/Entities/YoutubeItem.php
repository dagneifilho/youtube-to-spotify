<?php

namespace App\Entities;

class YoutubeItem
{
    public string $itemTitle;
    public string|null $title;
    public string|null $artist;
    public function __construct(string $itemTitle, string $title = null, string $artist = null) {
        $this->itemTitle = $itemTitle;
        $this->artist = $artist;
        $this->title = $title;
    }
    public static function fromData(array $data) : static {
        $ytTitle = $data['title'];
        $item = new static($ytTitle);
        $item->parseItemTitle();

        return $item;
    }
    public function parseItemTitle() : void{
        $aux = $this->itemTitle;

        if(str_contains($aux,'(')&&str_contains($aux,')')){
            $open = strpos($aux,'(');
            $close = strpos($aux,')');
            $len = $close - $open +1;
            $aux = substr_replace($aux,'',$open,$len);
        }
        if(str_contains($aux,'[')&&str_contains($aux,']')){
            $open = strpos($aux,'[');
            $close = strpos($aux,']');
            $len = $close - $open +1;
            $aux = substr_replace($aux,'',$open,$len);
        }

        $separator = '';

        if(str_contains($aux,'-'))
            $separator = '-';
        elseif (str_contains($aux,'-'))
            $separator = '.';
        elseif (str_contains($aux,':'))
            $separator=':';

        if($separator === ''){
            $this->title = $aux;
        } else {
            $data = explode($separator,$aux);
            $this->title = trim($data[1]);
            $this->artist = trim($data[0]);
        }
    }
}
