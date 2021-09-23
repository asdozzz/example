<?php

namespace App\Products\Ekasko\Infrastructure\Controller;

use App\Products\Ekasko\Business\UseCase\CalculateService;
use App\Products\Ekasko\Business\Model\Contract\Command\Calculate;
use App\Products\Ekasko\Business\Model\CalculateResponse;
use App\Infrastructure\Entity\GlobalApiResponse;
use App\Products\Ekasko\ReadModel\Query\GetCalculateResponseByContractId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class CalculateController extends AbstractController
{
    #[Route('/ekasko/calculate')]
    function __invoke(CalculateService $commandHandler, GetCalculateResponseByContractId $queryHandler): JsonResponse
    {
        $message = new Calculate(null, 'ALFA');
        $contractId = $commandHandler->handle($message);
        $response = $queryHandler->handle($contractId);
        $responseJson = $this->json(GlobalApiResponse::fromCommandResponse($response)->toArray());
        $responseJson->setEncodingOptions( $responseJson->getEncodingOptions() | JSON_PRETTY_PRINT );
        return $responseJson;
    }
}