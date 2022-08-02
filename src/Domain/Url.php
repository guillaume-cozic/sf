<?php

namespace App\Domain;

use App\Domain\Exception\InvalidState;

class Url
{
    private const PATTERN = '%^(?:(?:https?)://)(?:\S+(?::\S*)?@|\d{1,3}(?:\.\d{1,3}){3}|(?:(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)(?:\.(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)*(?:\.[a-z\x{00a1}-\x{ffff}]{2,6}))(?::\d+)?(?:[^\s]*)?$%iu';
    private $url;

    /**
     * @throws InvalidState
     */
    public function __construct(string $url)
    {
        $this->validate($url);
        $this->url = $url;
    }

    public function toString():string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return void
     * @throws InvalidState
     */
    private function validate(string $url)
    {
        $isValidUrl = preg_match(self::PATTERN, $url);
        if(!$isValidUrl){
            throw new InvalidState(InvalidState::INVALID_URL);
        }
    }
}