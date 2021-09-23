<?php

namespace App\Products\Ekasko\ReadModel\Repository;

use App\Products\Ekasko\Business\Model\CalculateResult;
use App\Products\Ekasko\Business\Model\Structure\ContractStructure;
use Doctrine\DBAL\Connection;

final class NosqlRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    function insert(ContractStructure $contractStructure): void
    {
        $this->connection->insert('ekasko_nosql',['uuid' => $contractStructure->getUuid(), 'data' => json_encode($contractStructure)]);
    }

    function update(ContractStructure $contractStructure): void
    {
        $this->connection->update('ekasko_nosql',['data' => json_encode($contractStructure)],['uuid' => $contractStructure->getUuid()]);
    }

    function getByUuid(string $uuid): array
    {
        $result = $this->connection->fetchAssociative('select data,uuid from ekasko_nosql where uuid = :uuid', ['uuid' => $uuid]);

        if (empty($result)) {
            throw new \Exception('Договор не найден');
        }

        return array('uuid' => $result['uuid'], 'data' => json_decode($result['data'], true));
    }

    function updateByCalculateResult(string $uuid, CalculateResult $calculateResult)
    {
        $premium = $calculateResult->getPremium();
        $query = "UPDATE ekasko_nosql SET data=data||'{\"premium\":$premium}' where uuid='$uuid'";
        $this->connection->executeQuery($query);
    }
}