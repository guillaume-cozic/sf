<?php

namespace App\Domain\Exception;

class InvalidState extends \Exception
{
    const INVALID_URL = 'INVALID_URL';
}