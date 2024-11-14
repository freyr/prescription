<?php
declare(strict_types=1);

namespace Freyr\Prescription\EventSourcing;

use DateTimeImmutable;
use DateTimeZone;

readonly class AggregateChanged
{
    public static function occur(Id $aggregateId, array $payload = []): static
    {
        $payload['_aggregate_id'] = (string) $aggregateId;
        $payload['_id'] = (string) $aggregateId;
        $payload['_name'] = get_called_class();
        /** @noinspection PhpUnhandledExceptionInspection */
        $occurredOn = new DateTimeImmutable('now', new DateTimeZone('UTC'));
        $payload['_occurred_on'] = $occurredOn;

        return new static(
            Id::new(),
            $aggregateId,
            $occurredOn,
            $payload
        );
    }

    public function __construct(
        public Id $eventId,
        public Id $aggregateId,
        public DateTimeImmutable $occurredOn,
        public array $payload
    )
    {
    }

    public static function fromArray(array $payload): static
    {
        $eventId = Id::fromString($payload['_id']);
        $aggregateId = Id::fromString($payload['_aggregate_id']);
        $occurredOn = new DateTimeImmutable($payload['_occurred_on'], new DateTimeZone('UTC'));
        return new static($eventId, $aggregateId, $occurredOn, $payload);
    }

    public function field($key)
    {
        return $this->payload[$key];
    }
}