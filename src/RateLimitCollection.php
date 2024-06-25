<?php

namespace Programster\Throttle;

use Programster\Collections\AbstractCollection;

class RateLimitCollection extends AbstractCollection
{
    public function __construct(RateLimit ...$rateLimits)
    {
        parent::__construct(RateLimit::class, ...$rateLimits);
    }
}