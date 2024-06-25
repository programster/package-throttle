<?php

/*
 * An interface for classes to implement for determining the identifier to be used in rate limiting for a request.
 * This may be the fetching of the client's IP address from various headers or the $_SERVER['REMOTE_ADDR'] variable,
 * or it could be the ID of a logged-in user etc.
 */

namespace Programster\Throttle;

use Psr\Http\Message\ServerRequestInterface;

interface RateLimitRequestIdentifierInterface
{
    public function getIdentifier(ServerRequestInterface $request) : string;
}