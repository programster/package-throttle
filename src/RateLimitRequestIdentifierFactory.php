<?php

/*
 * A factory for creating and returning whay are likely to be commonly used request identifiers. E.g. fetching
 * the user's IP address from a header.
 */

namespace Programster\Throttle;

use Psr\Http\Message\ServerRequestInterface;


class RateLimitRequestIdentifierFactory
{
    /**
     * An alias for createPhpServerAddr.
     * Creates a basic request identifier that pulls the visitor's IP from the $_SERVER['REMOTE_ADDR'].
     * This method should work if you aren't using any proxies at all.
     * @return RateLimitRequestIdentifierInterface
     */
    public static function createBasic() : RateLimitRequestIdentifierInterface
    {
        return self::createPhpServerAddr();
    }


    /**
     * Create a basic request identifier that pulls the visitor's IP from the $_SERVER['REMOTE_ADDR'].
     * This method should work if you aren't using any proxies at all.
     * @return RateLimitRequestIdentifierInterface
     */
    public static function createPhpServerAddr() : RateLimitRequestIdentifierInterface
    {
        return new class implements InterfaceRequestorIdentifier {
            public function getIdentifier(ServerRequestInterface $request): string
            {
                return $_SERVER['REMOTE_ADDR'];
            }
        };
    }


    /**
     * Create an identifier that will return the IP in the CF-Connecting-IP header that Cloudflare proxies
     * will put the IP of the requestor in.
     * @return RateLimitRequestIdentifierInterface
     */
    public static function createCloudflare() : RateLimitRequestIdentifierInterface
    {
        return new class implements InterfaceRequestorIdentifier {
            public function getIdentifier(ServerRequestInterface $request): string
            {
                $headers = $request->getHeader('CF-Connecting-IP');
                return end($headers);
            }
        };
    }


    /**
     * Create an identifier that will return the IP in the X-Forwarded-For header that is used
     * by most proxy software.
     * @return InterfaceRequestorIdentifier
     */
    public static function createForwardedForHeader() : InterfaceRequestorIdentifier
    {
        return new class implements InterfaceRequestorIdentifier {
            public function getIdentifier(ServerRequestInterface $request): string
            {
                $headers = $request->getHeader('X-Forwarded-For');
                return end($headers);
            }
        };
    }
}
