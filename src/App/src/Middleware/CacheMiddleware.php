<?php
/**
 * @license    https://opensource.org/licenses/BSD-3-Clause New BSD License
 * @Copyright  (c) 2017-2018, jailgreen <36865973+jailgreen@users.noreply.github.com>
 */

declare(strict_types=1);

namespace App\Middleware;

use Doctrine\Common\Cache\Cache;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response;

/**
 * Description of CacheMiddleware
 *
 * @author jailgreen <36865973+jailgreen@users.noreply.github.com>
 */
class CacheMiddleware implements MiddlewareInterface
{
    /**
     * @var Cache
     */
    private $cache;

    /**
     * @var bool
     */
    private $debug;

    public function __construct(Cache $cache, bool $debug = false)
    {
        $this->cache = $cache;
        $this->debug = $debug;
    }

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        $cachedResponse = $this->getCachedResponse($request);

        if (null !== $cachedResponse && true !== $this->debug) {
            return $cachedResponse;
        }

        $response = $handler->handle($request);

        if (true !== $this->debug) {
            $this->cacheResponse($request, $response);
        }

        return $response;
    }

    private function getCacheKey(ServerRequestInterface $request) : string
    {
        return 'http-cache:' . $request->getUri()->getPath();
    }

    private function getCachedResponse(ServerRequestInterface $request) : ?ResponseInterface
    {
        if ('GET' !== $request->getMethod()) {
            return null;
        }

        $item = $this->cache->fetch($this->getCacheKey($request));
        if (false === $item) {
            return null;
        }

        $response = new Response();

        $response->getBody()->write($item['body']);
        foreach ($item['headers'] as $header => $value) {
            $response = $response->withHeader($header, $value);
        }

        return $response;
    }

    private function cacheResponse(ServerRequestInterface $request, ResponseInterface $response) : void
    {
        if ('GET' !== $request->getMethod() || !$response->hasHeader('Cache-Control')) {
            return;
        }

        $cacheControl = $response->getHeader('Cache-Control');
        $abortTokens  = ['private', 'no-cache', 'no-store'];

        if (count(array_intersect($abortTokens, $cacheControl)) > 0) {
            return;
        }

        foreach ($cacheControl as $value) {
            $parts = explode('=', $value);

            if (count($parts) == 2 && 'max-age' === $parts[0]) {
                $this->cache->save(
                    $this->getCacheKey($request),
                    [
                    'body'    => (string) $response->getBody(),
                    'headers' => $response->getHeaders(),
                    ],
                    (int) $parts[1]
                );

                return;
            }
        }
    }
}
