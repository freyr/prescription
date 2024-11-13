<?php

declare(strict_types=1);

namespace Freyr\Prescription\Issuing\Core;

use Freyr\Prescription\Issuing\Core\Issuer\Issuer;

interface CancelPrescription
{

    public function prescriptionId(): PrescriptionId;

    public function getIssuer(): Issuer;
}