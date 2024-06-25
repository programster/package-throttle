<?php

/*
 * A data object for storing information about a desired rate limit. E.g. how many requests are allowed
 * in a set time period.
 */

namespace Programster\Throttle;


class RateLimitOverflow
{
    /**
     * Create an allowed rate limit. E.g. the number of requests allowed in a set amount of time.
     * @param int $numAllowedRequests - the number of requests allowed
     * @param int $timePeriodInSeconds - the time period the number of requests are allowed within.
     */
    public function __construct(public readonly RateLimit $rateLimit, public readonly int $numRequestsRecieved)
    {
        // Check to make sure that the number of requests does actually exceed the specified rate limit.
        if ($numRequestsRecieved <= $rateLimit->numAllowedRequests)
        {
            throw new RateLimitOverflowException("Specified number of requests received does not exceed the provided rate limit.");
        }
    }
}
