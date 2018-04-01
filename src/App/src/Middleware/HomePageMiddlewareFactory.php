<?php
/**
 * @license    https://opensource.org/licenses/BSD-3-Clause New BSD License
 * @Copyright  (c) 2017-2018, jailgreen <36865973+jailgreen@users.noreply.github.com>
 */

declare(strict_types=1);

namespace App\Middleware;

use Psr\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class HomePageMiddlewareFactory
{
    public function __invoke(ContainerInterface $container) : HomePageMiddleware
    {
        return new HomePageMiddleware($container->get(TemplateRendererInterface::class));
    }
}
