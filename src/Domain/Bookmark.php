<?php

declare(strict_types=1);

namespace App\Domain;

class Bookmark
{
    private $id;
    private $url;
    private $linkInfo;

    public function __construct(string $id, Url $url, LinkInfo $linkInfo)
    {
        $this->id = $id;
        $this->url = $url;
        $this->linkInfo = $linkInfo;
    }

    public function toArray():array
    {
        return array_merge([
            'id' => $this->id,
            'url' => $this->url->toString(),
        ], $this->linkInfo->toArray());
    }

    public function getId():string
    {
        return $this->id;
    }
}