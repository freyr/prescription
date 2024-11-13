<?php

declare(strict_types=1);

namespace Freyr\Prescription\Issuing\Core;

use Freyr\Prescription\Issuing\Core\Physician\Physician;
use Freyr\Prescription\Issuing\Core\Prescription\PrescriptionId;

interface CancelPrescription
{

    public function prescriptionId(): PrescriptionId;

    public function getPhysician(): Physician;
}