<?php

namespace App\Infrastructure\Repository;

use App\Infrastructure\Interfaces\CanProjectToModelOfRead;
use App\Products\Ekasko\Business\Model\Contract;
use Doctrine\DBAL\Connection;
use EventSauce\EventSourcing\EventSourcedAggregateRootRepository;
use EventSauce\EventSourcing\MessageConsumer;
use EventSauce\EventSourcing\Serialization\ConstructingMessageSerializer;
use EventSauce\EventSourcing\SynchronousMessageDispatcher;
use EventSauce\MessageRepository\DoctrineV2MessageRepository\DoctrineUuidV4MessageRepository;
use EventSauce\MessageRepository\TableSchema\DefaultTableSchema;
use EventSauce\UuidEncoding\StringUuidEncoder;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

abstract class EventSourcedRepository
{
    protected EventSourcedAggregateRootRepository $aggregateRootRepository;

    const TABLE_NAME = 'event_store';

    abstract protected function getClassName(): string;


    /**
     * @param Connection $connection
     * @param CanProjectToModelOfRead[] $projections
     */
    public function __construct(
        Connection $connection,
        #[TaggedIterator('app.es.projection')] iterable $projections
    )
    {
        $constructingMessageSerializer = new ConstructingMessageSerializer();
        $messageRepository = new DoctrineUuidV4MessageRepository(
            connection: $connection,
            tableName: self::TABLE_NAME,
            serializer: $constructingMessageSerializer,
            tableSchema: new DefaultTableSchema(), // optional
            uuidEncoder: new StringUuidEncoder(), // optional
        );


        $messageDispatcher = new SynchronousMessageDispatcher(...$projections);

        $this->aggregateRootRepository = new EventSourcedAggregateRootRepository(
            $this->getClassName(),
            $messageRepository,
            $messageDispatcher
        );
    }
}