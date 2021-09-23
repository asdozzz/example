<?php

namespace App\Products\Ekasko\ReadModel\Projection;

use App\Infrastructure\Interfaces\CanProjectToModelOfRead;
use App\Products\Ekasko\Business\Model\Contract\ContractWasCreatedByCalculateRequest;
use App\Products\Ekasko\Business\Model\Contract\ContractWasUpdatedByCalculateRequest;
use App\Products\Ekasko\Business\Model\Contract\PremiumWasCalculated;
use App\Products\Ekasko\ReadModel\Repository\NosqlRepository;
use EventSauce\EventSourcing\Message;

final class ContractNosqlProjection  implements CanProjectToModelOfRead
{
    private NosqlRepository $nosqlRepository;

    public function __construct(NosqlRepository $nosqlRepository)
    {
        $this->nosqlRepository = $nosqlRepository;
    }

    public function handle(Message $message): void
    {
        $event = $message->event();

        if ($event instanceof ContractWasCreatedByCalculateRequest) {
            $this->nosqlRepository->insert($event->getContractStructure());
        } else if ($event instanceof ContractWasUpdatedByCalculateRequest) {
            $this->nosqlRepository->update($event->getContractStructure());
        } else if ($event instanceof PremiumWasCalculated) {
            $this->nosqlRepository->updateByCalculateResult($event->getUuid(), $event->getCalculateResult());
        }
    }
}