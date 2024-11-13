<?php

declare(strict_types=1);

namespace Freyr\Prescription\Issuing\ReadModel;

use Freyr\Prescription\Issuing\Core\Prescription\PrescriptionIssued;

class UpdateSinglePrescriptionReadModelCommandHandler
{

    public function __construct(private SinglePrescriptionRepository $repository)
    {

    }

    public function __invoke(PrescriptionIssued $prescriptionIssued): void
    {
        $this->repository->update(
            $prescriptionIssued->field('patientId'),
            (int) $prescriptionIssued->field(['code'])
        );
    }
}