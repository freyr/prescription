<?php

declare(strict_types=1);

namespace Freyr\Prescription\Issuing\Core\Patient;


interface PatientRepository
{

    public function findByPesel(Pesel $pesel): Patient;
}