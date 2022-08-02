<?php

namespace App\Domain;

interface LinkInfoProvider
{
    public function get(string $link):LinkInfo;
}