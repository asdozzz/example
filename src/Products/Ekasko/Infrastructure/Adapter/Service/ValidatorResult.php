<?php

namespace App\Products\Ekasko\Infrastructure\Adapter\Service;

final class ValidatorResult implements \App\Products\Ekasko\Business\Port\Service\CanThrowExceptionFromArrayErrors
{

    function throwExceptionByArrayErrors(array $errors): \Exception
    {
        return new \Exception(join(', ', $errors));
    }
}