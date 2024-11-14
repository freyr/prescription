<?php

declare(strict_types=1);

namespace Freyr\Prescription\Issuing\Core\Prescription;

use Freyr\Prescription\EventSourcing\AggregateChanged;
use Freyr\Prescription\Issuing\Core\Patient\PatientId;

readonly class PrescriptionIssued extends AggregateChanged
{
    public function getPatientId(): PatientId
    {
        return PatientId::fromString($this->payload['patientId']);
    }
}