<?php

declare(strict_types=1);

namespace Freyr\Prescription\Issuing\Core\Patient;

use Freyr\Prescription\Issuing\Core\Pesel;

interface PatientRepository
{

    public function findByPesel(Pesel $pesel): Patient;
}