<?php

namespace App\Infrastructure\Entity;

use App\Infrastructure\Entity\Interfaces\CanGetData;

abstract class AbstractResponse implements CanGetData
{
    function getData(): self
    {
        return $this;
    }
}