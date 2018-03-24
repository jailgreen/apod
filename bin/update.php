<?php
/**
 * @license    https://opensource.org/licenses/BSD-3-Clause New BSD License
 * @Copyright  (c) 2017-2018, jailgreen <36865973+jailgreen@users.noreply.github.com>
 */

declare(strict_types=1);

chdir(__DIR__ . '/..');

include 'vendor/autoload.php';

$container = include 'config/container.php';

// Create a SIGINT handler that sets a shutdown flag
$shutdown = false;
pcntl_async_signals(true); // turn on async signals

pcntl_signal(SIGINT,  function() use (&$shutdown) {
    $shutdown = true;
    echo 'SIGINT\n';
});

$newPictureHandler = function (array $picture) use (&$shutdown) {
    echo 'Added: ' . $picture['title'] . PHP_EOL;

    // If the shutdown flag has been set, die
    if ($shutdown) {
        die;
    }
};

$errorHandler = function (Exception $exception) use (&$shutdown) {
    echo (string) $exception . PHP_EOL;

    // If the shutdown flag has been set, die
    if ($shutdown) {
        die;
    }
};

$container->get(AndrewCarterUK\APOD\APIInterface::class)
        ->updateStore(20, $newPictureHandler, $errorHandler);
