<?php
/**
 * @license    https://opensource.org/licenses/BSD-3-Clause New BSD License
 * @Copyright  (c) 2017-2018, jailgreen <36865973+jailgreen@users.noreply.github.com>
 */

declare(strict_types=1);

namespace JGreen\Apod\Handler;

use AndrewCarterUK\APOD\APIInterface;
use Psr\Container\ContainerInterface;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;

class PictureListHandlerFactory
{
    public function __invoke(ContainerInterface $container) : PictureListHandler
    {
        $apodApi = $container->get(APIInterface::class);
        $config  = $container->get('config');

        if (!isset($config['application']['results_per_page'])) {
            throw new ServiceNotCreatedException('results_per_page must be set in application configuration');
        }

        return new PictureListHandler($apodApi, $config['application']['results_per_page']);
    }
}
