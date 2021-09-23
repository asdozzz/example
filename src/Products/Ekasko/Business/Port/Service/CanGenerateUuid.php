<?php


namespace App\Products\Ekasko\Business\Port\Service;


interface CanGenerateUuid
{
    function generate(): string;
}