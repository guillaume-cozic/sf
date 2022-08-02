<?php

namespace App\Application\form;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;

class DeleteBookmarkForm
{
    private $id;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('id', new NotBlank());
    }

    public function setId(string $id)
    {
        $this->id = $id;
    }
}