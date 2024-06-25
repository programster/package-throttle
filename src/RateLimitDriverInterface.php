<?php

namespace Programster\Throttle;

interface RateLimitDriverInterface
{
    /**
     * Processes the request, returning the rate limits that the request exceeds. If the array is empty
     * then the request did not exceed any rate limits.
     * @param string $requestIdentifier - the identifier for the request. This might be the request's IP address, or
     * the users unique UUID etc.
     * @param RateLimitCollection $rateLimits - a collection of rate limits to compare against.
     * @return RateLimitOverflowCollection - a collection of rate limits that were exceeded.
     */
    public function process(string $requestIdentifier, string $throttleId, RateLimitCollection $rateLimits) : RateLimitOverflowCollection;
}