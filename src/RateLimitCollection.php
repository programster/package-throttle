<?php

namespace Programster\Throttle;

class RateLimitCollection extends Programster\Collections\AbstractCollection
{
    public function __construct(RateLimit ...$rateLimits)
    {
        parent::__construct(RateLimit::class, ...$rateLimits);
    }
}