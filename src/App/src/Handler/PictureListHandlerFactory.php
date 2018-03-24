<?php
/**
 * @license    https://opensource.org/licenses/BSD-3-Clause New BSD License
 * @Copyright  (c) 2017-2018, jailgreen <36865973+jailgreen@users.noreply.github.com>
 */

declare(strict_types=1);

namespace JGreen\Apod\Handler;

use Psr\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class PictureListHandlerFactory
{
    public function __invoke(ContainerInterface $container) : PictureListHandler
    {
        return new PictureListHandler($container->get(TemplateRendererInterface::class));
    }
}
