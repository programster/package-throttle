<?php

namespace Programster\Throttle;

use Programster\Throttle\Exceptions\RateLimitMissingException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RateLimitMiddleware implements MiddlewareInterface
{
    /**
     * Create a middleware for rate-limiting/throttling requests.
     * @param string $throttleIdentifier - an identifier for this throttler/rate-limiter. This is typically used for
     * grouping routes that you wish to throttle. E.g. you may wish to apply a throttle for all of the public routes,
     * and a separate one for the login page of an admin area. For this, you might use 'login' as the identifier for
     * this middleware, attaching it to the login route, and the string 'public' for the middleware you create and
     * attach to each of the public routes.
     * @param RateLimitDriverInterface $driver - the driver for handling rate limiting. E.g. do you wish to use Redis,
     * MySQL, PostgreSQL or some other storage mechanism for storing requests and checking limits.
     * @param RateLimitRequestIdentifierInterface $requestIdentifier - a class that will take a request and return the
     * appropriate string identifier to represent the request for checking rate limits against. This will most likely
     * be something that returns the requesters IP address, or account UUID.
     * @param RateLimitedRequestHandlerInterface $throttledRequestHandler - a handler to handle the request should it
     * have failed one or more of the rate limits
     * @param RateLimitCollection $rateLimits - a collection of rate limits to apply. E.g. you may wish for requests
     * to never exceed one per second, and no more than 5 in 60 seconds etc.
     * @throws \Exception
     */
    public function __construct(
        private readonly string                              $throttleIdentifier,
        private readonly RateLimitDriverInterface            $driver,
        private readonly RateLimitRequestIdentifierInterface $requestIdentifier,
        private readonly RateLimitedRequestHandlerInterface  $throttledRequestHandler,
        private readonly RateLimitCollection                 $rateLimits
    )
    {
        if (count($rateLimits) < 1)
        {
            throw new RateLimitMissingException("No rate limits were provided to the rate limiting middleware.");
        }
    }


    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $requesterIpOrIdentity = $this->requestIdentifier->getIdentifier($request);

        $exceededRateLimits = $this->driver->process(
            $requesterIpOrIdentity,
            $this->throttleIdentifier,
            $this->rateLimits
        );

        if (count($exceededRateLimits) > 0)
        {
            $response = $this->throttledRequestHandler->handle($request, $exceededRateLimits);
        }
        else
        {
            $response = $handler->handle($request);
        }

        return $response;
    }
}
