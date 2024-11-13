<?php

declare(strict_types=1);

namespace Freyr\Prescription\Issuing\Core\Physician;

interface PhysicianRepository
{

    public function getById(PhysicianId $getPhysicianId);
}