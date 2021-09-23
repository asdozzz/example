<?php


namespace App\Products\Ekasko\Infrastructure\Adapter\Service;


use App\Products\Ekasko\Business\Port\Service\CanGenerateUuid;
use Symfony\Component\Uid\Uuid;

final class GeneratorUuidService implements CanGenerateUuid
{
    function generate(): string
    {
        return Uuid::v4();
    }
}