<?php

declare(strict_types=1);

namespace Freyr\Prescription\Issuing\Core\Patient;

class Patient
{

    public function __construct(private PatientId $id)
    {

    }

    public function isInsured(): bool
    {
        return true;
    }

    public function getId(): PatientId
    {
        return $this->id;
    }
}