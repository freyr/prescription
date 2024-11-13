<?php

declare(strict_types=1);

namespace Freyr\Prescription\Issuing\Core;

use Freyr\Prescription\Issuing\Core\Prescription\Prescription;

interface PrescriptionRepository
{

    public function persist(Prescription $prescription): void;
}