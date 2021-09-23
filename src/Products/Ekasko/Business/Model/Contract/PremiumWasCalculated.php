<?php

namespace App\Products\Ekasko\Business\Model\Contract;

use App\Products\Ekasko\Business\Model\CalculateResult;
use EventSauce\EventSourcing\Serialization\SerializablePayload;

final class PremiumWasCalculated implements SerializablePayload
{
    public function __construct(private string $uuid, private CalculateResult $calculateResult)
    {
    }

    /**
     * @return CalculateResult
     */
    public function getCalculateResult(): CalculateResult
    {
        return $this->calculateResult;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function toPayload(): array
    {
        return array(
            'premium' => $this->calculateResult->getPremium(),
            'uuid' => $this->uuid,
        );
    }

    public static function fromPayload(array $payload): SerializablePayload
    {
        return new static($payload['uuid'], new CalculateResult($payload['premium']));
    }
}