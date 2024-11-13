<?php

declare(strict_types=1);

namespace Freyr\Prescription\Issuing\Core;

use Freyr\Prescription\Issuing\Core\Physician\Physician;
use Freyr\Prescription\Issuing\Core\Medicine\Medicine;
use Freyr\Prescription\Issuing\Core\Patient\Patient;

interface PhysicianPrescriptionStatus
{

    public function canIssue(Physician $issuer, Patient $patient, Medicine $medication);
}