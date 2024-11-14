<?php

declare(strict_types=1);

namespace Freyr\Prescription\Issuing\Application;

use Freyr\Prescription\Issuing\Core\CancelPrescription;
use Freyr\Prescription\Issuing\Core\Physician\Physician;
use Freyr\Prescription\Issuing\Core\Prescription\PrescriptionId;

class FakeCancelPrescription implements CancelPrescription
{

    public function __construct(private PrescriptionId $id, private Physician $physician)
    {

    }
    public function prescriptionId(): PrescriptionId
    {
        return $this->id;
    }

    public function getPhysician(): Physician
    {
        return $this->physician;
    }
}