<?php

declare(strict_types=1);

namespace Freyr\Prescription\Issuing\Core;

use Freyr\Prescription\Issuing\Core\Issuer\Issuer;

interface IssuePrescription
{

    public function getIssuer(): Issuer;

    public function getPatientPesel(): Pesel;

    public function getMedicationId(): MedicationId;

    public function getQuantity(): int;
}