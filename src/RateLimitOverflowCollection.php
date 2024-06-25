<?php

namespace Programster\Throttle;

use Programster\Collections\AbstractCollection;

class RateLimitOverflowCollection extends AbstractCollection
{
    public function __construct(RateLimitOverflow ...$rateLimitOverflow)
    {
        parent::__construct(RateLimitOverflow::class, ...$rateLimitOverflow);
    }
}