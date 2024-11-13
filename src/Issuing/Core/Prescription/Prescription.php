<?php

declare(strict_types=1);

namespace Freyr\Prescription\Issuing\Core\Prescription;

use Freyr\Prescription\Issuing\Core\ChangePrescription;
use Freyr\Prescription\Issuing\Core\Issuer\Issuer;
use Freyr\Prescription\Issuing\Core\Medication\Medication;
use Freyr\Prescription\Issuing\Core\Patient\Patient;

class Prescription
{

    public function __construct(
        private Patient $patient,
        private Issuer $issuer
    )
    {
    }

    public function addMedication(Medication $medication, int $getQuantity)
    {

    }

    public function createBasedOn(ChangePrescription $prescription): self
    {
        $new = new self($this->patient, $this->issuer);

        $this->cancel();

        return $new;
    }

    private function cancel()
    {

    }
}