<?php

declare(strict_types=1);

namespace Freyr\Prescription\Issuing\Core;

use Freyr\Prescription\Issuing\Core\Issuer\Issuer;
use Freyr\Prescription\Issuing\Core\Medication\Medication;
use Freyr\Prescription\Issuing\Core\Patient\Patient;

interface DoctorPermissionRepository
{

    public function canIssue(Issuer $issuer, Patient $patient, Medication $medication);
}