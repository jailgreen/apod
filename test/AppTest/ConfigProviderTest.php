<?php
/**
 * @license    https://opensource.org/licenses/BSD-3-Clause New BSD License
 * @Copyright  (c) 2017-2018, jailgreen <36865973+jailgreen@users.noreply.github.com>
 */

declare(strict_types=1);

namespace ApodTest;

use JGreen\Apod\ConfigProvider;
use JGreen\Apod\Middleware;
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

    public function testProviderDefinesExpectedFactoryServices()
    {
        $config = $this->provider->getDependencies();
        $factories = $config['factories'];

        $this->assertArrayHasKey(Middleware\HomePageMiddleware::class, $factories);
    }

    public function testProviderDefinesExpectedTemplates()
    {
        $config = $this->provider->getTemplates();
        $templates = $config['paths'];

        $this->assertArrayHasKey('app', $templates);
        $this->assertArrayHasKey('error', $templates);
        $this->assertArrayHasKey('layout', $templates);
    }

    public function testInvocationReturnsArrayWithDependencies(): void
    {
        $config = ($this->provider)();

        $this->assertInternalType('array', $config);
        $this->assertArrayHasKey('dependencies', $config);
        $this->assertArrayHasKey('factories', $config['dependencies']);

        $this->assertCount(1, $config['dependencies']['factories']);

        $this->assertArrayHasKey('templates', $config);
    }
}
