<?php


namespace App\Products\Ekasko\Infrastructure\Adapter\Repository;


use App\Infrastructure\Repository\EventSourcedRepository;
use App\Products\Ekasko\Business\Model\Contract;
use App\Products\Ekasko\Business\Model\ContractId;
use App\Products\Ekasko\Business\Model\Structure\ContractStructure;
use App\Products\Ekasko\Business\Port\Repository\IContractRepository;
use App\Products\Ekasko\Business\Model\Contract\Command\Calculate;
use Doctrine\DBAL\Connection;
use EventSauce\EventSourcing\EventSourcedAggregateRootRepository;
use EventSauce\EventSourcing\Serialization\ConstructingMessageSerializer;
use EventSauce\EventSourcing\SynchronousMessageDispatcher;
use EventSauce\MessageOutbox\DoctrineV2Outbox\DoctrineOutboxRepository;
use EventSauce\MessageOutbox\OutboxMessageDispatcher;
use EventSauce\MessageRepository\DoctrineV2MessageRepository\DoctrineUuidV4MessageRepository;
use EventSauce\MessageRepository\TableSchema\DefaultTableSchema;
use EventSauce\MessageRepository\TableSchema\LegacyTableSchema;
use EventSauce\UuidEncoding\BinaryUuidEncoder;
use EventSauce\UuidEncoding\StringUuidEncoder;

final class ContractRepository extends EventSourcedRepository implements IContractRepository
{
    function getByUuid(string $uuid): Contract
    {
        $result = $this->aggregateRootRepository->retrieve(ContractId::fromString($uuid));
        return $result;
    }

    function saveContract(Contract $contract): void
    {
        $this->aggregateRootRepository->persist($contract);
    }

    protected function getClassName(): string
    {
        return Contract::class;
    }
}