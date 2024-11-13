<?php

declare(strict_types=1);

namespace Freyr\Prescription\Issuing\Core;

class CancelPrescriptionCommandHandler
{

    public function __construct(
        private PrescriptionRepository $prescriptionRepository
    )
    {

    }

    /**
     * @param CancelPrescription $command
     * @return void
     * @throws CannotCancelPrescriptionException
     */
    public function __invoke(CancelPrescription $command): void
    {
        $prescription = $this->prescriptionRepository->loadById($command->prescriptionId());
        $prescription->cancel($command);
        $this->prescriptionRepository->persist($prescription);
    }
}