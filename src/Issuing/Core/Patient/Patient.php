<?php

declare(strict_types=1);

namespace Freyr\Prescription\Issuing\Core\Patient;

class Patient
{

    public function isInsured(): bool
    {
        return true;
    }

    public function getId(): string
    {
        return '';
    }
}