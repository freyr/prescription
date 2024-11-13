<?php

declare(strict_types=1);

namespace Freyr\Prescription\Issuing\Core;

use Freyr\Prescription\Issuing\Core\Medication\Medication;

interface MedicationRepository
{

    public function getById(MedicationId $getMedicationId): Medication;
}