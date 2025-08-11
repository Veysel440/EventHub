<?php

namespace App\Modules\Payments\Application;

use App\Modules\Payments\Application\Contracts\PaymentProvider;
use InvalidArgumentException;

class PaymentProviderFactory
{
    /** @param PaymentProvider[] $providers */
    public function __construct(private iterable $providers) {}

    public function get(string $name): PaymentProvider
    {
        foreach ($this->providers as $p) {
            if ($p->name() === $name) return $p;
        }
        throw new InvalidArgumentException("unknown_provider: {$name}");
    }
}
