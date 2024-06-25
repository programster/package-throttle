<?php

/*
 * A data object for storing information about a desired rate limit. E.g. how many requests are allowed
 * in a set time period.
 */

namespace Programster\Throttle;


class RateLimit
{
    /**
     * Create an allowed rate limit. E.g. the number of requests allowed in a set amount of time.
     * @param int $numAllowedRequests - the number of requests allowed
     * @param int $timePeriodInSeconds - the time period the number of requests are allowed within.
     */
    public function __construct(public readonly int $numAllowedRequests, public readonly int $timePeriodInSeconds,)
    {

    }
}
