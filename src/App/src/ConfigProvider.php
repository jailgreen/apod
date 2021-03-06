<?php
/**
 * @license    https://opensource.org/licenses/BSD-3-Clause New BSD License
 * @Copyright  (c) 2017-2018, jailgreen <36865973+jailgreen@users.noreply.github.com>
 */

declare(strict_types=1);

namespace App;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     */
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
            'application'  => $this->getApplicationParams(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'factories'  => [
                Handler\HomePageHandler::class    => Handler\HomePageHandlerFactory::class,
                Handler\PictureListHandler::class => Handler\PictureListHandlerFactory::class,
                Middleware\CacheMiddleware::class => Middleware\CacheFactory::class,

                \AndrewCarterUK\APOD\APIInterface::class => Factory\APIFactory::class,
                \Doctrine\Common\Cache\Cache::class      => Factory\CacheFactory::class,
            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates() : array
    {
        return [
            'paths' => [
                'app'    => ['templates/app'],
                'error'  => ['templates/error'],
                'layout' => ['templates/layout'],
            ],
        ];
    }

    /**
     * Returns application configuration parameters.
     * @return array
     */
    public function getApplicationParams() : array
    {
        return [
            'results_per_page' => 24,
            'apod_api' => [
                'store_path' => 'public/apod',
                'base_url'   => '/apod',
                'api_key'    => 'KwJrvP1slfzelmGFJNnVfh2NVF9SuwhDTXPxYx8a',
            ],
        ];
    }
}
