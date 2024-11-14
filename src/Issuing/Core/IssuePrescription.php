<?php

declare(strict_types=1);

namespace Freyr\Prescription\Issuing\Core;

use Freyr\Prescription\Issuing\Core\Medicine\Dosage;
use Freyr\Prescription\Issuing\Core\Patient\Pesel;
use Freyr\Prescription\Issuing\Core\Physician\PhysicianId;

interface IssuePrescription
{

    public function getPatientPesel(): Pesel;

    /**
     * @return array<int, Dosage>
     */
    public function getDosages(): array;

    public function getPhysicianId(): PhysicianId;
}