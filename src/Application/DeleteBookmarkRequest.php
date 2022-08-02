<?php

namespace App\Application;

class DeleteBookmarkRequest
{
    private $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId():string
    {
        return $this->id;
    }
}