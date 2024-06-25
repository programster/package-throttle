<?php

/*
 * An interface for classes to implement for handling a request that exceeded some rate limits.
 */

namespace Programster\Throttle;

use Psr\Http\Message\ServerRequestInterface;

interface RateLimitedRequestHandlerInterface
{
    /**
     * Handle a request that failed the provided rate limits
     * @param ServerRequestInterface $request - the request that was recieved.
     * @param RateLimitCollection $exceededRateLimits - the collection of rate limits that were exceeded. This may
     * be useful information that you may wisht to provide in the response.
     * @return ResponseInterface - the responese to hand back to the requester.
     */
    public function handle(ServerRequestInterface $request, RateLimitCollection $exceededRateLimits) : ResponseInterface;
}