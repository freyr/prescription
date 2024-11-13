<?php

declare(strict_types=1);

namespace Freyr\Prescription\Issuing\Core\Prescription;

use Freyr\Prescription\Issuing\Core\CancelPrescription;
use Freyr\Prescription\Issuing\Core\CannotCancelPrescriptionException;
use Freyr\Prescription\Issuing\Core\ChangePrescription;
use Freyr\Prescription\Issuing\Core\Issuer\Issuer;
use Freyr\Prescription\Issuing\Core\Medication\Medication;
use Freyr\Prescription\Issuing\Core\Patient\Patient;

class Prescription
{

    public function __construct(
        readonly private Patient $patient,
        readonly private Issuer $issuer,
        private PrescriptionStatus $status = PrescriptionStatus::ISSUED,
    )
    {
    }

    public function addMedication(Medication $medication, int $getQuantity)
    {

    }

    public function cancel(CancelPrescription $command): void
    {
        if ($this->issuer !== $command->getIssuer()) {
            throw new CannotCancelPrescriptionException();
        }
        $this->status = PrescriptionStatus::CANCELLED;

    }

    public function canBeExecuted(): bool
    {
        return $this->status !== PrescriptionStatus::CANCELLED;
    }
}