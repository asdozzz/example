<?php

namespace App\Products\Ekasko\Business\Model;

final class CalculateResult
{
    function __construct(
        private float $premium
    ){}

    /**
     * @return float
     */
    public function getPremium(): float
    {
        return $this->premium;
    }


}