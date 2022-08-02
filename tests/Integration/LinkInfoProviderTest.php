<?php

namespace App\Tests\Integration;

use App\Domain\Exception\LinkInfoNotRetrieved;
use App\Domain\LinkInfo;
use App\Infrastructure\LinkInfoGateway;
use PHPUnit\Framework\TestCase;

class LinkInfoProviderTest extends TestCase
{
    /**
     * @test
     */
    public function shouldRetrieveLinkInfoForVimeo()
    {
        $url = 'https://vimeo.com/188075559';
        $linkInfoGateway = new LinkInfoGateway();

        $linkInfo = $linkInfoGateway->get($url);

        $linkInfoExpected = new LinkInfo('Vimeo', 'Black Holes','Meat Dept.', null, 426, 194, '');
        self::assertEquals($linkInfoExpected, $linkInfo);
    }

    /**
     * @test
     */
    public function shouldRetrieveLinkInfoForFlickr()
    {
        $url = 'https://www.flickr.com/photos/tedementa/2087306393';
        $linkInfoGateway = new LinkInfoGateway();

        $linkInfo = $linkInfoGateway->get($url);

        $linkInfoExpected = new LinkInfo('Flickr', 'a','- lala', null, 567, 610, null);
        self::assertEquals($linkInfoExpected, $linkInfo);
    }

    /**
     * @test
     */
    public function shouldNotRetrieveLinkInfoForA404Page()
    {
        $url = 'https://www.youtube.com/testgjgtjfjfj';
        $linkInfoGateway = new LinkInfoGateway();

        $this->expectException(LinkInfoNotRetrieved::class);
        $this->expectExceptionMessage('404 link not found');
        $linkInfoGateway->get($url);
    }
}