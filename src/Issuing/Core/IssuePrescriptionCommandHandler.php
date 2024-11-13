<?php

declare(strict_types=1);

namespace Freyr\Prescription\Issuing\Core;

use Freyr\Prescription\Issuing\Core\Medicine\MedicineRepository;
use Freyr\Prescription\Issuing\Core\Patient\PatientRepository;
use Freyr\Prescription\Issuing\Core\Physician\PhysicianRepository;
use Freyr\Prescription\Issuing\Core\Prescription\Prescription;
use Freyr\Prescription\Issuing\Core\Prescription\PrescriptionRepository;
use RuntimeException;

final readonly class IssuePrescriptionCommandHandler
{

    public function __construct(
        private PatientRepository $patientRepository,
        private MedicineRepository $medicineRepository,
        private PrescriptionRepository $prescriptionRepository,
        private PhysicianRepository $physicianRepository
    )
    {

    }
    public function __invoke(IssuePrescription $command): void
    {
        $patient = $this->patientRepository->findByPesel($command->getPatientPesel());
        $physician = $this->physicianRepository->getById($command->getPhysicianId());

        $prescription = Prescription::issue(
            $this->medicineRepository,
            $patient,
            $physician,
            ...$command->getDosages()
        );

        $this->prescriptionRepository->persist($prescription);
    }
}