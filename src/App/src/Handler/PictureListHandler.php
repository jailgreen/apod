<?php
/**
 * @license    https://opensource.org/licenses/BSD-3-Clause New BSD License
 * @Copyright  (c) 2017-2018, jailgreen <36865973+jailgreen@users.noreply.github.com>
 */

declare(strict_types=1);

namespace JGreen\Apod\Handler;

use AndrewCarterUK\APOD\APIInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;

class PictureListHandler implements RequestHandlerInterface
{
    /**
     * @var APIInterface
     */
    private $apodApi;

    /**
     * @var int
     */
    private $resultsPerPage;

    public function __construct(APIInterface $apodApi, int $resultsPerPage)
    {
        $this->apodApi        = $apodApi;
        $this->resultsPerPage = $resultsPerPage;
    }

    /**
     * {@inheritDoc}
     */
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $page     = intval($request->getAttribute('page') ?: 0);
        $pictures = $this->apodApi->getPage($page, $this->resultsPerPage);
        // Do some work...
        // Render and return a response:
        return new JsonResponse($pictures);
        //return new JsonResponse($pictures);
    }
}
