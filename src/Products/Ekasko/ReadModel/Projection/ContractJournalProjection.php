<?php

namespace App\Products\Ekasko\ReadModel\Projection;

use App\Infrastructure\Interfaces\CanProjectToModelOfRead;
use App\Products\Ekasko\Business\Model\Contract\ContractWasCreatedByCalculateRequest;
use App\Products\Ekasko\Business\Model\Contract\ContractWasUpdatedByCalculateRequest;
use App\Products\Ekasko\Business\Model\Contract\PremiumWasCalculated;
use App\Products\Ekasko\ReadModel\Repository\ContractFirstProjectionRepository;
use EventSauce\EventSourcing\Message;

final class ContractJournalProjection implements CanProjectToModelOfRead
{
    private ContractFirstProjectionRepository $sqlRepository;

    public function __construct(ContractFirstProjectionRepository $sqlRepository)
    {
        $this->sqlRepository = $sqlRepository;
    }

    public function handle(Message $message): void
    {
        $event = $message->event();

        if ($event instanceof ContractWasCreatedByCalculateRequest) {
            $this->sqlRepository->insert($event->getContractStructure());
        } else if ($event instanceof ContractWasUpdatedByCalculateRequest) {
            $this->sqlRepository->update($event->getContractStructure());
        } else if ($event instanceof PremiumWasCalculated) {
            $this->sqlRepository->updateByCalculateResult($event->getUuid(), $event->getCalculateResult());
        }
    }
}