<?php

namespace App\Integrations\Alfa\Infrastructure\Adapters;

use App\Products\Ekasko\Business\Model\Contract;

abstract class AbstractAdapter
{
    function isSatisfitedBy(Contract $contract)
    {
        return $contract->getCompany() == 'ALFA';
    }
}