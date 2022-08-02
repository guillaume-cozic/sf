<?php

namespace App\Tests\Adapters;

use App\Domain\Exception\LinkInfoNotRetrieved;
use App\Domain\LinkInfo;
use App\Domain\LinkInfoProvider;

class InMemoryLinkInfoProvider implements LinkInfoProvider
{
    private $link = [];

    public function __construct()
    {
        $this->link['http://url-valide.com'] = new LinkInfo(
            'youtube',
            'title',
            'author',
            '2022-05-04',
            '10',
            '20',
            '11'
        );
    }

    public function get(string $link):LinkInfo
    {
        if($link === 'http://url-with-timeout.com'){
            throw new LinkInfoNotRetrieved('Erreur timeout');
        }
        return $this->link[$link] ?? new LinkInfo(
            '',
            '',
            '',
            '',
            '',
            '',
            ''
        );
    }
}