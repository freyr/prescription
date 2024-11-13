<?php

declare(strict_types=1);

namespace Freyr\Prescription\Claiming\Core;

final readonly class Identity
{

    public function __construct(
        public int $code,
        public Pesel $pesel
    )
    {

    }
    public function sameAs(Identity $identity): bool
    {
        return $this->code === $identity->code && $this->pesel->sameAs($identity->pesel);
    }
}