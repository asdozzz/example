<?php

namespace App\Infrastructure\Entity;

use App\Infrastructure\Entity\Interfaces\CanGetData;

final class GlobalApiResponse
{
    protected function __construct(
        private bool $success,
        private mixed $data,
    ) {}

    static function fromCommandResponse(mixed $data)
    {
        return new self(true, $data);
    }

    static function fromException(\Throwable $throwable)
    {
        return new self(false, ['error' => $throwable->getMessage()]);
    }

    function toArray()
    {
        $array = array(
            'success' => $this->success,
            'data' => $this->data,
        );
        return $array;
    }
}