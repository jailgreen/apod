<?php

/**
 * @license    https://opensource.org/licenses/BSD-3-Clause New BSD License
 * @Copyright  (c) 2017-2018, jailgreen <36865973+jailgreen@users.noreply.github.com>
 */

declare(strict_types=1);

namespace App\Factory;

use Doctrine\Common\Cache\CacheProvider;
use Doctrine\Common\Cache\FilesystemCache;
use Psr\Container\ContainerInterface;

/**
 * Description of CacheFactory
 *
 * @author jailgreen <36865973+jailgreen@users.noreply.github.com>
 */
class CacheFactory
{
    public function __invoke(ContainerInterface $container) : CacheProvider
    {
        return new FilesystemCache('data/cache');
    }
}
