<?php

declare(strict_types=1);

namespace Freyr\Prescription\Issuing\Core\Physician;

class Physician
{
    public function __construct(public readonly PhysicianId $id)
    {

    }
}