<?php

namespace App\Products\Ekasko\Business\UseCase;

use App\Products\Ekasko\Business\Model\Contract;
use App\Products\Ekasko\Business\Port\Repository\IContractRepository;
use App\Products\Ekasko\Business\Port\Service\CanThrowExceptionFromArrayErrors;
use App\Products\Ekasko\Business\Service\CompanyAdapterResolver;
use App\Products\Ekasko\Business\Model\Contract\Command\Calculate;
use App\Products\Ekasko\Business\Port\Service\CanGenerateUuid;
use App\Products\Ekasko\Business\Model\CalculateResponse;

class CalculateService
{
    public function __construct(
        private CanGenerateUuid $generatorUuid,
        private IContractRepository $contractRepository,
        private CompanyAdapterResolver $companyAdapterResolver,
        private CanThrowExceptionFromArrayErrors $validatorResult
    ) {}

    function handle(Calculate $calculateCommand): string
    {
        $errors = Contract::CanCalculate($calculateCommand);

        if (!empty($errors)) {
            throw $this->validatorResult->throwExceptionByArrayErrors($errors);
        }

        if ($calculateCommand->getUuid()) {
            $contract = $this->contractRepository->getByUuid($calculateCommand->getUuid());
            $contract->updateFromCalculateCommand($calculateCommand);
        } else {
            $uuid = $this->generatorUuid->generate();
            $contract = Contract::fromCalculateCommand($uuid, $calculateCommand);
        }

        $adapter = $this->companyAdapterResolver->getAdapterByContract($contract);
        $calculateResult = $adapter->calculate($contract);
        $contract->setCalculateResult($calculateResult);
        $this->contractRepository->saveContract($contract);
        return $contract->getUuid();
    }
}