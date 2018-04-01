<?php
/**
 * @license    https://opensource.org/licenses/BSD-3-Clause New BSD License
 * @Copyright  (c) 2017-2018, jailgreen <36865973+jailgreen@users.noreply.github.com>
 */

declare(strict_types=1);

namespace AppTest\Handler;

use App\Handler\HomePageHandler;
use App\Handler\HomePageHandlerFactory;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Description of HomePageMiddlewareFactoryTest
 *
 * @author jailgreen <36865973+jailgreen@users.noreply.github.com>
 */
class HomePageHandlerFactoryTest extends TestCase
{
    public function testFactory()
    {
        $factory   = new HomePageHandlerFactory();
        $container = $this->prophesize(ContainerInterface::class);

        $container
                ->get(TemplateRendererInterface::class)
                ->shouldBeCalled()
                ->willReturn($this->prophesize(TemplateRendererInterface::class));

        $page = $factory($container->reveal());

        $this->assertInstanceOf(HomePageHandler::class, $page);
        $this->assertInstanceOf(RequestHandlerInterface::class, $page);
    }
}
