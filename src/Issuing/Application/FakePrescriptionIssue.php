<?php

declare(strict_types=1);

namespace Freyr\Prescription\Issuing\Application;

use Freyr\Prescription\Issuing\Core\IssuePrescription;
use Freyr\Prescription\Issuing\Core\Medicine\Dosage;
use Freyr\Prescription\Issuing\Core\Medicine\MedicineId;
use Freyr\Prescription\Issuing\Core\Patient\Pesel;
use Freyr\Prescription\Issuing\Core\Physician\PhysicianId;

class FakePrescriptionIssue implements IssuePrescription
{

    public function getPatientPesel(): Pesel
    {
        return new Pesel();
    }

    public function getDosages(): array
    {
        return [
            new Dosage(MedicineId::new(), '1', 1, 1)
        ];
    }

    public function getPhysicianId(): PhysicianId
    {
        return PhysicianId::new();
    }
}