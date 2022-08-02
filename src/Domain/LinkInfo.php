<?php

declare(strict_types=1);

namespace App\Domain;

class LinkInfo
{
    private $provider;
    private $title;
    private $author;
    private $publishedDate;
    private $width;
    private $height;
    private $duration;

    public function __construct(
        ?string $provider,
        ?string $title,
        ?string $author,
        ?string $publishedDate,
        ?string $width,
        ?string $height,
        ?string $duration
    )
    {
        $this->provider = $provider;
        $this->title = $title;
        $this->author = $author;
        $this->publishedDate = $publishedDate;
        $this->width = $width;
        $this->height = $height;
        $this->duration = $duration;
    }

    public function toArray():array
    {
        return [
            'provider' => $this->provider,
            'title' => $this->title,
            'author' => $this->author,
            'published_date' => $this->publishedDate,
            'width' => $this->width,
            'height' => $this->height,
            'duration' => $this->duration,
        ];
    }
}