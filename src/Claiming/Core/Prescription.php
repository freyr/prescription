<?php

declare(strict_types=1);

namespace Freyr\Prescription\Claiming\Core;

class Prescription
{
    public function __construct(
        readonly private Identity $identity,
        private array $fulfilment = [],
    ) {
    }

    public function confirmIdentity(int $code, Pesel $pesel): bool
    {
        $identity = new Identity($code, $pesel);
        return $this->identity->sameAs($identity);
    }

    public function fulfill(
        MedicineId $medicineId,
        int $quantity,
    ): void
    {
        if (array_key_exists((string) $medicineId, $this->fulfilment) && $this->fulfilment[(string)$medicineId] > 0) {
            $prescriptionQuantity = $this->fulfilment[(string) $medicineId];
            $this->fulfilment[(string) $medicineId] = $prescriptionQuantity - $quantity;
        }
    }

    public function isFullyFilled(): bool
    {
        foreach ($this->fulfilment as $quantity) {
            if ($quantity > 0) {
                return false;
            }
        }

        return true;
    }
}