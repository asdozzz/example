<?php

namespace App\Products\Ekasko\Business\Service;

use App\Products\Ekasko\Business\Model\Contract;
use App\Products\Ekasko\Business\Port\Service\ICompanyAdapter;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

final class CompanyAdapterResolver
{
    /** @var ICompanyAdapter[]*/
    private $adapters;

    public function __construct(
        #[TaggedIterator('app.ekasko.company_adapter')] iterable $handlers
    )
    {
        $this->adapters = $handlers;
    }

    function getAdapterByContract(Contract $contract): ICompanyAdapter
    {
        $adapterResult = null;

        foreach ($this->adapters as $adapter) {
            if ($adapter->isSatisfitedBy($contract)) {
                $adapterResult = $adapter;
                break;
            }
        }

        if (empty($adapterResult)) {
            throw new \Exception(sprintf('Adapter not found'));
        }

        return $adapterResult;
    }
}