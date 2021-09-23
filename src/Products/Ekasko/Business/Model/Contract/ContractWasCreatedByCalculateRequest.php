<?php

namespace App\Products\Ekasko\Business\Model\Contract;

use App\Products\Ekasko\Business\Model\Structure\ContractStructure;
use EventSauce\EventSourcing\Serialization\SerializablePayload;

final class ContractWasCreatedByCalculateRequest implements SerializablePayload
{
    public function __construct(private ContractStructure $contractStructure)
    {
    }

    /**
     * @return ContractStructure
     */
    public function getContractStructure(): ContractStructure
    {
        return $this->contractStructure;
    }


    public function toPayload(): array
    {
        $temp = serialize($this->contractStructure);
        $class = ContractStructure::class;
        $count = strlen($class);
        $serialize = preg_replace("@^O:8:\"stdClass\":@", "O:$count:\"$class\":", $temp);
        return array(
            'contractStructure' => $serialize
        );
    }

    public static function fromPayload(array $payload): SerializablePayload
    {
        return new static(unserialize($payload['contractStructure']));
    }
}