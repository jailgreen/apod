<?php

/**
 * @license    https://opensource.org/licenses/BSD-3-Clause New BSD License
 * @Copyright  (c) 2017-2018, jailgreen <36865973+jailgreen@users.noreply.github.com>
 */

declare(strict_types=1);

namespace App\Middleware;

use Doctrine\Common\Cache\Cache;
use Psr\Container\ContainerInterface;

/**
 * Description of CacheFactory
 *
 * @author jailgreen <36865973+jailgreen@users.noreply.github.com>
 */
class CacheFactory
{
    public function __invoke(ContainerInterface $container) : CacheMiddleware
    {
        $config = $container->has('config') ? $container->get('config') : [];
        $debug  = array_key_exists('debug', $config) ? (bool) $config['debug'] : false;

        $cache = $container->get(Cache::class);

        return new CacheMiddleware($cache, $debug);
    }
}
