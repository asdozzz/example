<?php

namespace App\Products\Ekasko\Business\Model\Structure;

use App\Products\Ekasko\Business\Model\CalculateResult;
use App\Products\Ekasko\Business\Model\Contract\Command\Calculate;

final class ContractStructure
{
    private ?float $premium;
    protected function __construct(
        private string $uuid,
        private string $company,
    ){ }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @return string
     */
    public function getCompany(): string
    {
        return $this->company;
    }

    /**
     * @return float|null
     */
    public function getPremium(): ?float
    {
        return $this->premium;
    }

    static function createFromCalculateCommand(string $uuid,Calculate $calculate): self
    {
        return new self($uuid, $calculate->getCompany());
    }

    function setCalculateResult(CalculateResult $calculateResult): void
    {
        $this->premium = $calculateResult->getPremium();
    }
}