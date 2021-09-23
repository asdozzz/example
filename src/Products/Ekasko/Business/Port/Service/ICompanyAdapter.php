<?php


namespace App\Products\Ekasko\Business\Port\Service;


use App\Products\Ekasko\Business\Model\CalculateResult;
use App\Products\Ekasko\Business\Model\Contract;

interface ICompanyAdapter
{
    function isSatisfitedBy(Contract $contract);

    function calculate(Contract $contract): CalculateResult;
    function createProject(Contract $contract);
    function getPrintFormList(Contract $contract);
    function getPrintForm(Contract $contract, string $printCode);
    function getPayLink(Contract $contract);
    function acceptance(Contract $contract);
}