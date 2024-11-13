<?php

declare(strict_types=1);

namespace Freyr\Prescription\Issuing\Core\Prescription;

interface PrescriptionRepository
{

    public function persist(Prescription $prescription): void;

    public function loadById(PrescriptionId $prescriptionId): Prescription;
}