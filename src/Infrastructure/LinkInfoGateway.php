<?php

namespace App\Infrastructure;

use App\Domain\Exception\LinkInfoNotRetrieved;
use App\Domain\LinkInfo;
use App\Domain\LinkInfoProvider;
use Embed\Embed;

class LinkInfoGateway implements LinkInfoProvider
{
    private $embed;

    public function __construct()
    {
        $this->embed = new Embed();
    }

    public function get(string $link): LinkInfo
    {
        try {
            $info = $this->embed->get($link);
            if($info->getResponse()->getStatusCode() === 404){
                throw new LinkInfoNotRetrieved('404 link not found');
            }
            $width = $info->code->width;
            $height = $info->code->height;
            $duration = $info->getMetas()->get('duration') !== null ? $info->getMetas()->get('duration')[0] : '';

            return new LinkInfo(
                $info->providerName,
                $info->title,
                $info->authorName,
                $info->publishedTime !== null ? $info->publishedTime->format('Y-m-d H:i:s') : null,
                $width,
                $height,
                $duration
            );
        }catch (\Throwable $e){
            throw new LinkInfoNotRetrieved($e);
        }
    }
}