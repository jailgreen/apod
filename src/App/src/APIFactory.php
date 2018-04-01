<?php
/**
 * @license    https://opensource.org/licenses/BSD-3-Clause New BSD License
 * @Copyright  (c) 2017-2018, jailgreen <36865973+jailgreen@users.noreply.github.com>
 */

declare(strict_types=1);

namespace App;

use AndrewCarterUK\APOD\API;
use AndrewCarterUK\APOD\APIInterface;
use GuzzleHttp\Client;
use Psr\Container\ContainerInterface;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;

/**
 * Description of APIFactory
 *
 * @author jailgreen <36865973+jailgreen@users.noreply.github.com>
 */
class APIFactory
{
    public function __invoke(ContainerInterface $container): APIInterface
    {
        //$config = $container->get('application');
        $config = $container->get('config');

        if (!isset($config['application']['apod_api'])) {
            throw new ServiceNotCreatedException('apod_api must be set in application configuration');
        }

        return new API(new Client(), $config['application']['apod_api']);
    }
}
