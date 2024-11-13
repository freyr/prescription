<?php

declare(strict_types=1);

namespace Freyr\Prescription\Issuing\Core;

use Freyr\Prescription\Issuing\Core\Patient\PatientRepository;
use Freyr\Prescription\Issuing\Core\Prescription\Prescription;
use RuntimeException;

final readonly class IssuePrescriptionCommandHandler
{

    public function __construct(
        private PatientRepository $patientRepository,
        private MedicationRepository $medicationRepository,
        private PrescriptionRepository $prescriptionRepository,
        private DoctorPermissionRepository $doctorPermissionRepository
    )
    {

    }
    public function __invoke(IssuePrescription $command): void
    {
        $patient = $this->patientRepository->findByPesel($command->getPatientPesel());
        if (!$patient->isInsured()) {
            throw new RuntimeException('Patient is not insured');
        }

        $medication = $this->medicationRepository->getById($command->getMedicationId());
        $issuer = $command->getIssuer();
        if (!$this->doctorPermissionRepository->canIssue($issuer, $patient, $medication)) {
            throw new RuntimeException('Cannot issue prescription for medication');
        }

        $prescription = new Prescription($patient, $issuer);
        $prescription->addMedication($medication, $command->getQuantity());

        $this->prescriptionRepository->persist($prescription);
    }
}