<?php

declare(strict_types=1);

namespace Freyr\Prescription\Issuing\Core\Prescription;

use Freyr\Prescription\EventSourcing\AggregateChanged;
use Freyr\Prescription\EventSourcing\AggregateRoot;
use Freyr\Prescription\Issuing\Core\CancelPrescription;
use Freyr\Prescription\Issuing\Core\Medicine\Dosage;
use Freyr\Prescription\Issuing\Core\Medicine\MedicineRepository;
use Freyr\Prescription\Issuing\Core\Patient\Patient;
use Freyr\Prescription\Issuing\Core\Physician\Physician;
use RuntimeException;

class Prescription extends AggregateRoot
{

    private int $code;
    /**
     * @var Dosage[]
     */
    private array $dosages;

    public function __construct(
        readonly private PrescriptionId $id,
        readonly private Patient $patient,
        readonly private Physician $physician,
        private PrescriptionStatus $status = PrescriptionStatus::ISSUED,
        Dosage ...$dosages,
    ) {
        $this->code = rand(1, 9999);
        $this->dosages = $dosages;
    }

    public static function issue(
        MedicineRepository $medicineRepository,
        Patient $patient,
        Physician $physician,
        Dosage ...$dosages,
    ): self
    {
        foreach ($dosages as $dosage) {
            if (!$medicineRepository->check($dosage)) {
                throw new RuntimeException('Incorrect medicine');
            }
        }

        $prescription = new self(
            PrescriptionId::new(),
            $patient,
            $physician,
            PrescriptionStatus::ISSUED,
            ...$dosages,
        );
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

    public function cancel(CancelPrescription $command): void
    {
        if ($this->physician !== $command->getPhysician()) {
            throw new CannotCancelPrescriptionException();
        }
        $this->status = PrescriptionStatus::CANCELLED;
    }

    public function aggregateId(): string
    {
        return (string)$this->id;
    }

    protected function apply(AggregateChanged $event): void
    {
    }
}