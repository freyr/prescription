<?php

declare(strict_types=1);

namespace Freyr\Prescription\Issuing\Core\Prescription;

use Freyr\Prescription\EventSourcing\AggregateChanged;
use Freyr\Prescription\EventSourcing\AggregateRoot;
use Freyr\Prescription\Issuing\Core\CancelPrescription;
use Freyr\Prescription\Issuing\Core\CannotCancelPrescriptionException;
use Freyr\Prescription\Issuing\Core\Issuer\Issuer;
use Freyr\Prescription\Issuing\Core\Medication\Medication;
use Freyr\Prescription\Issuing\Core\Patient\Patient;
use Freyr\Prescription\Issuing\Core\PrescriptionId;

class Prescription extends AggregateRoot
{

    private int $code;

    public function __construct(
        readonly private PrescriptionId $id,
        readonly private Patient $patient,
        readonly private Issuer $issuer,
        private PrescriptionStatus $status = PrescriptionStatus::ISSUED,
    ) {
        $this->code = rand(1, 9999);
    }

    public static function issue(Patient $patient, Issuer $issuer, Medication $medication, int $quantity)
    {
        $prescription = new self(new PrescriptionId(), $patient, $issuer, PrescriptionStatus::ISSUED);
        $prescription->addMedication($medication, $quantity);
        $prescription->recordThat(
            new PrescriptionIssued(
                $prescription->aggregateId(),
                [
                    'patientId' => $patient->getId(),
                    'code' => $prescription->code
                ]
            )
        );
        return $prescription;
    }

    private function addMedication(Medication $medication, int $getQuantity)
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

    public function aggregateId(): string
    {
        return (string)$this->id;
    }

    protected function apply(AggregateChanged $event): void
    {
    }
}