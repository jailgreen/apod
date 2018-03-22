<?php
/**
 * @license    https://opensource.org/licenses/BSD-3-Clause New BSD License
 * @Copyright  (c) 2017-2018, jailgreen <36865973+jailgreen@users.noreply.github.com>
 */

declare(strict_types=1);

namespace ApodTest;

use JGreen\Apod\ConfigProvider;
use PHPUnit\Framework\TestCase;

/**
 * Description of ConfigProviderTest
 *
 * @author jailgreen <36865973+jailgreen@users.noreply.github.com>
 */
class ConfigProviderTest extends TestCase
{
    /**
     * @var ConfigProvider
     */
    private $provider;

    protected function setUp(): void
    {
        $this->provider = new ConfigProvider();
    }

    public function testInvocationReturnsArrayWithDependencies(): void
    {
        $config = ($this->provider)();

        $this->assertInternalType('array', $config);
        $this->assertArrayHasKey('dependencies', $config);
        $this->assertArrayHasKey('factories', $config['dependencies']);
        $this->assertCount(0, $config['dependencies']['factories']);

        $this->assertArrayHasKey('templates', $config);
        $this->assertArrayHasKey('app', $config['templates']['paths']);
        $this->assertArrayHasKey('error', $config['templates']['paths']);
        $this->assertArrayHasKey('layout', $config['templates']['paths']);
    }
}
