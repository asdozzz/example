<?php

namespace App\Products\Ekasko\Business\Model;

use App\Products\Ekasko\Business\Model\Contract\ContractWasCreatedByCalculateRequest;
use App\Products\Ekasko\Business\Model\Contract\ContractWasUpdatedByCalculateRequest;
use App\Products\Ekasko\Business\Model\Contract\PremiumWasCalculated;
use App\Products\Ekasko\Business\Model\Structure\ContractStructure;
use App\Products\Ekasko\Business\Model\Contract\Command\Calculate;
use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootBehaviour;


final class Contract implements AggregateRoot
{
    use AggregateRootBehaviour;
    private ?ContractStructure $contractStructure;

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->aggregateRootId->toString();
    }

    /**
     * @og
     * */
    public function getCompany(): string
    {
        return $this->contractStructure->getCompany();
    }


    static function CanCalculate(Calculate $calculate): array
    {
        $errors = array();

        if (strlen($calculate->getCompany()) < 3) {
            $errors[] = 'COMPANY_NAME_TOO_SHORT';
        }

        return $errors;
    }

    static function fromCalculateCommand(string $uuid, Calculate $calculate): self
    {
        $errors = self::CanCalculate($calculate);

        if (!empty($errors)) {
            throw new \Exception('CalculateRequest is invalid');
        }

        $structure = ContractStructure::createFromCalculateCommand($uuid, $calculate);
        $contract = new static(ContractId::fromString($uuid));
        $contract->recordThat(new ContractWasCreatedByCalculateRequest($structure));

        return $contract;
    }

    public function applyContractWasCreatedByCalculateRequest(ContractWasCreatedByCalculateRequest $event)
    {
        $this->contractStructure = $event->getContractStructure();
    }

    function updateFromCalculateCommand(Calculate $calculate): void
    {
        $errors = self::CanCalculate($calculate);

        if (!empty($errors)) {
            throw new \Exception('CalculateRequest is invalid');
        }
        $structure = ContractStructure::createFromCalculateCommand($calculate);
        $this->recordThat(new ContractWasUpdatedByCalculateRequest($structure));
    }

    public function applyContractWasUpdatedByCalculateRequest(ContractWasUpdatedByCalculateRequest $event)
    {
        $this->contractStructure = $event->getContractStructure();
    }

    function setCalculateResult(CalculateResult $calculateResult): void
    {
        $this->recordThat(new PremiumWasCalculated($this->getUuid(), $calculateResult));
    }

    public function applyPremiumWasCalculated(PremiumWasCalculated $event)
    {
        $this->contractStructure->setCalculateResult($event->getCalculateResult());
    }

    function getPremium(): ?float
    {
        return $this->contractStructure->getPremium();
    }
}