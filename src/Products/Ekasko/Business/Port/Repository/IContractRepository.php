<?php


namespace App\Products\Ekasko\Business\Port\Repository;


use App\Products\Ekasko\Business\Model\Contract;
use Ecotone\Modelling\EventSourcedRepository;

interface IContractRepository
{
    function getByUuid(string $uuid): Contract;

    function saveContract(Contract $contract): void;
}