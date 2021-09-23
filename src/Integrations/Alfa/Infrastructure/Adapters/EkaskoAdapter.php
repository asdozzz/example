<?php

namespace App\Integrations\Alfa\Infrastructure\Adapters;

use App\Products\Ekasko\Business\Model\CalculateResult;
use App\Products\Ekasko\Business\Model\Contract;
use App\Products\Ekasko\Business\Port\Service\ICompanyAdapter;

final class EkaskoAdapter extends AbstractAdapter implements ICompanyAdapter
{
    function calculate(Contract $contract): CalculateResult
    {
        return new CalculateResult(152);
    }

    function createProject(Contract $contract)
    {
        // TODO: Implement createProject() method.
    }

    function getPrintFormList(Contract $contract)
    {
        // TODO: Implement getPrintFormList() method.
    }

    function getPrintForm(Contract $contract, string $printCode)
    {
        // TODO: Implement getPrintForm() method.
    }

    function getPayLink(Contract $contract)
    {
        // TODO: Implement getPayLink() method.
    }

    function acceptance(Contract $contract)
    {
        // TODO: Implement acceptance() method.
    }
}