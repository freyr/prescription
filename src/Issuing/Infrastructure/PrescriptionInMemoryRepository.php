<?php

declare(strict_types=1);

namespace Freyr\Prescription\Issuing\Infrastructure;

use Freyr\Prescription\EventSourcing\AggregateChanged;
use Freyr\Prescription\Issuing\Core\Prescription\Prescription;
use Freyr\Prescription\Issuing\Core\Prescription\PrescriptionId;
use Freyr\Prescription\Issuing\Core\Prescription\PrescriptionRepository;

class PrescriptionInMemoryRepository implements PrescriptionRepository
{

    public function __construct(private EventEmitter $emitter)
    {

    }
    private array $prescriptions = [];

    public function persist(Prescription $prescription): void
    {
        $this->prescriptions[$prescription->aggregateId()] = $prescription;
        $eventExtractor = fn() => $this->popRecordedEvents();

        $events = $eventExtractor->call($prescription);

        /** @var AggregateChanged $event */
        foreach ($events as $event) {
            $publicEvent = new PrescriptionIssuedIntegrationEvent(
                $prescription->aggregateId(),
                $event->field('patientId'),
                $event->field('code'),
            );
            $this->emitter->emit($publicEvent);
        }
        //commit

    }

    public function loadById(PrescriptionId $prescriptionId): Prescription
    {
        return $this->prescriptions[(string) $prescriptionId];
    }
}