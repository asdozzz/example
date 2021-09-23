<?php

namespace App\Products\Ekasko\ReadModel\Query;

use App\Products\Ekasko\Business\Model\CalculateResponse;
use App\Products\Ekasko\Business\Port\Repository\IContractRepository;
use App\Products\Ekasko\ReadModel\Repository\ContractFirstProjectionRepository;
use App\Products\Ekasko\ReadModel\Repository\NosqlRepository;
use Doctrine\DBAL\Connection;

final class GetCalculateResponseByContractId
{
    private ContractFirstProjectionRepository $contractNoSqlRepository;
    private NosqlRepository $nosqlRepository;

    public function __construct(ContractFirstProjectionRepository $contractNoSqlRepository, NosqlRepository $nosqlRepository)
    {
        $this->contractNoSqlRepository = $contractNoSqlRepository;
        $this->nosqlRepository = $nosqlRepository;
    }

    function handle(string $uuid): CalculateResponse
    {
        $result = $this->contractNoSqlRepository->getByUuid($uuid);
        $result2 = $this->nosqlRepository->getByUuid($uuid);
        return CalculateResponse::fromArray($result, $result2);
    }
}