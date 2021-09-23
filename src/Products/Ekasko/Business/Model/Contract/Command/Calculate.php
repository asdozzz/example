<?php

namespace App\Products\Ekasko\Business\Model\Contract\Command;

class Calculate
{
    public function __construct(
        private ?string $uuid,
        private ?string $company
    ) { }

    /**
     * @return string|null
     */
    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    /**
     * @return string|null
     */
    public function getCompany(): ?string
    {
        return $this->company;
    }


}