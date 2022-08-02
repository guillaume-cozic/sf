<?php

namespace App\Application\form;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreateBookmarkForm
{
    private $url;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('url', new NotBlank());
    }

    public function setUrl(string $url)
    {
        $this->url = $url;
    }
}