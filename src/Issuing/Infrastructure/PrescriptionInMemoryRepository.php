<?php

declare(strict_types=1);

namespace Freyr\Prescription\Issuing\Infrastructure;

use Freyr\Prescription\EventSourcing\AggregateChanged;
use Freyr\Prescription\Issuing\Core\Prescription\Prescription;
use Freyr\Prescription\Issuing\Core\Prescription\PrescriptionId;
use Freyr\Prescription\Issuing\Core\Prescription\PrescriptionRepository;

class PrescriptionInMemoryRepository implements PrescriptionRepository
{

    public array $events = [];

    public function __construct()
    {

    }
    public array $prescriptions = [];

    public function persist(Prescription $prescription): void
    {
        $this->prescriptions[(string) $prescription->id] = $prescription;
        $eventExtractor = fn() => $this->popRecordedEvents();

        $events = $eventExtractor->call($prescription);
        $this->events = $events;
        /** @var AggregateChanged $event */
        foreach ($events as $event) {
            $publicEvent = new PrescriptionIssuedIntegrationEvent(
            (string) $prescription->id,
                $event->field('patientId'),
                $event->field('code'),
            );
        }
        //commit

    }

    public function loadById(PrescriptionId $prescriptionId): Prescription
    {
        return $this->prescriptions[(string) $prescriptionId];
    }
}