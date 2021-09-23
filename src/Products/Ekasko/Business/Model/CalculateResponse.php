<?php

namespace App\Products\Ekasko\Business\Model;

use App\Products\Ekasko\Business\Model\Contract;
use App\Products\Ekasko\Business\Model\Structure\ContractStructure;

final class CalculateResponse
{
    protected function __construct(private array $linear, private array $nosql)
    {

    }
    static function fromArray(array $result, array $result2): self
    {
        return new self($result, $result2);
    }

    /**
     * @return array
     */
    public function getLinear(): array
    {
        return $this->linear;
    }

    /**
     * @return array
     */
    public function getNosql(): array
    {
        return $this->nosql;
    }

}