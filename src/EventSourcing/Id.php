<?php

declare(strict_types=1);

namespace Freyr\Prescription\EventSourcing;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Id
{

    public function __construct(protected UuidInterface $id)
    {
    }

    public static function new(): static
    {
        return new static(Uuid::uuid7());
    }

    public static function fromBinary(string $bytes): static
    {
        $uuid = Uuid::fromBytes($bytes);
        return new static($uuid);
    }

    public static function fromString(string $uuid): static
    {
        return new static(Uuid::fromString($uuid));
    }

    public function __toString(): string
    {
        return $this->id->toString();
    }

    public function toBinary(): string
    {
        return $this->id->toString();
    }
}