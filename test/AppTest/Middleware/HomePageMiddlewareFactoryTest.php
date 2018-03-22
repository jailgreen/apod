<?php
/**
 * @license    https://opensource.org/licenses/BSD-3-Clause New BSD License
 * @Copyright  (c) 2017-2018, jailgreen <36865973+jailgreen@users.noreply.github.com>
 */

declare(strict_types=1);

namespace ApodTest\Middleware;

use JGreen\Apod\Middleware\HomePageMiddleware;
use JGreen\Apod\Middleware\HomePageMiddlewareFactory;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Description of HomePageMiddlewareFactoryTest
 *
 * @author jailgreen <36865973+jailgreen@users.noreply.github.com>
 */
class HomePageMiddlewareFactoryTest extends TestCase
{
    public function testFactory()
    {
        $factory   = new HomePageMiddlewareFactory();
        $container = $this->prophesize(ContainerInterface::class);

        $container
                ->get(TemplateRendererInterface::class)
                ->shouldBeCalled()
                ->willReturn($this->prophesize(TemplateRendererInterface::class));

        $page = $factory($container->reveal());

        $this->assertInstanceOf(HomePageMiddleware::class, $page);
        $this->assertInstanceOf(MiddlewareInterface::class, $page);
    }
}
