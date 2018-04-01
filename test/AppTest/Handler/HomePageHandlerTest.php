<?php
/**
 * @license    https://opensource.org/licenses/BSD-3-Clause New BSD License
 * @Copyright  (c) 2017-2018, jailgreen <36865973+jailgreen@users.noreply.github.com>
 */

declare(strict_types=1);

namespace AppTest\Handler;

use App\Handler\HomePageHandler;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Description of HomePageMiddlewareTest
 *
 * @author jailgreen <36865973+jailgreen@users.noreply.github.com>
 */
class HomePageHandlerTest extends TestCase
{
    public function testResponseRendersCorrectPage()
    {
        $renderer = $this->prophesize(TemplateRendererInterface::class);
        $renderer
                ->render('app::home', Argument::type('array'))
                ->shouldBeCalled()
                ->willReturn('page-content');
        $request = $this->prophesize(ServerRequestInterface::class);
        //$handler = $this->prophesize(RequestHandlerInterface::class);

        $page = new HomePageHandler($renderer->reveal());
        $response = $page->handle($request->reveal());

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals('page-content', $response->getBody());
        $this->assertEquals(200, $response->getStatusCode());
    }
}
