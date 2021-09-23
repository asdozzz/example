<?php

namespace App\Products\Ekasko\Business\Model;

use EventSauce\EventSourcing\AggregateRootId;

final class ContractId implements AggregateRootId
{
    private $id;

    private function __construct(string $id)
    {
        $this->id = $id;
    }

    public function toString(): string
    {
        return $this->id;
    }

    public static function fromString(string $id): AggregateRootId
    {
        return new static($id);
    }
}