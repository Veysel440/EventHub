<?php

namespace App\Modules\Payments\Application;

use App\Modules\Payments\Application\Contracts\PaymentCreator;
use InvalidArgumentException;

class PaymentCreatorFactory
{
    /** @param PaymentCreator[] $creators */
    public function __construct(private iterable $creators) {}

    public function get(string $name): PaymentCreator
    {
        foreach ($this->creators as $c) {
            if ($c->name() === $name) return $c;
        }
        throw new InvalidArgumentException("unknown_provider: {$name}");
    }
}
