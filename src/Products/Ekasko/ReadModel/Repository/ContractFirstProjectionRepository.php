<?php

namespace App\Products\Ekasko\ReadModel\Repository;

use App\Products\Ekasko\Business\Model\CalculateResult;
use App\Products\Ekasko\Business\Model\Contract;
use App\Products\Ekasko\Business\Model\ContractId;
use App\Products\Ekasko\Business\Model\Structure\ContractStructure;
use App\Products\Ekasko\Business\Port\Repository\IContractRepository;
use Doctrine\DBAL\Connection;
use Symfony\Component\Serializer\SerializerInterface;

final class ContractFirstProjectionRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    function insert(ContractStructure $contractStructure): void
    {
        $this->connection->insert('ekasko',['uuid' => $contractStructure->getUuid(), 'status' => 'waiting_response', 'premium' => 0]);
    }

    function update(ContractStructure $contractStructure): void
    {
        $this->connection->update('ekasko',['status' => 'waiting_response', 'premium' => 0],['uuid' => $contractStructure->getUuid()]);
    }

    function getByUuid(string $uuid): array
    {
        $result = $this->connection->fetchAssociative('select status,premium,uuid from ekasko where uuid = :uuid', ['uuid' => $uuid]);

        if (empty($result)) {
            throw new \Exception('Договор не найден');
        }

        return $result;
    }

    function updateByCalculateResult(string $uuid, CalculateResult $calculateResult)
    {
        $this->connection->update('ekasko',['status' => 'was_calculated', 'premium' => $calculateResult->getPremium()],['uuid' => $uuid]);
    }
}