<?php
/**
 * @license    https://opensource.org/licenses/BSD-3-Clause New BSD License
 * @Copyright  (c) 2017-2018, jailgreen <36865973+jailgreen@users.noreply.github.com>
 */

declare(strict_types=1);

namespace AppTest\Factory;

use AndrewCarterUK\APOD\API;
use App\Factory\APIFactory;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Psr\Container\ContainerInterface;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;

/**
 * Description of APIFactoryTest
 *
 * @author jailgreen <36865973+jailgreen@users.noreply.github.com>
 */
class APIFactoryTest extends TestCase
{
    public function testAPIFactory(): void
    {
        $factory = new APIFactory();
        $container = $this->prophesize(ContainerInterface::class);

        $container->get('config')
                ->shouldBeCalled()
                ->willReturn(['application' => ['apod_api' => ['store_path' => '/', 'base_url' => '/']]]);

        $api = $factory($container->reveal());
        $this->assertInstanceOf(API::class, $api);
    }

    public function testAPIFactoryThrowsException(): void
    {
        $factory = new APIFactory();
        $container = $this->prophesize(ContainerInterface::class);

        $container->get('config')
                ->shouldBeCalled()
                ->willReturn([]);

        $this->expectException(ServiceNotCreatedException::class);
        $this->expectExceptionMessage('apod_api must be set in application configuration');

        $api = $factory($container->reveal());
    }
}
