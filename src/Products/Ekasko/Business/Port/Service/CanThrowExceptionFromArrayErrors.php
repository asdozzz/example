<?php

namespace App\Products\Ekasko\Business\Port\Service;

interface CanThrowExceptionFromArrayErrors
{
    function throwExceptionByArrayErrors(array $errors): \Exception;
}