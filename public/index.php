<?php
require_once __DIR__.'/../vendor/autoload.php';

use \Symfony\Component\HttpFoundation\Request;
use \Propel\Runtime\Map\TableMap;
use \Symfony\Component\HttpKernel\HttpKernelInterface;

$app = new Silex\Application();
$app->register(new Propel\Silex\PropelServiceProvider(), array(
    'propel.config_file' => __DIR__.'/../config/config.php'
));
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../view',
));
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

$app->get('/info', function () use ($app) {
    phpinfo();
});

$app->mount('/package', new \Packagerator\Controller\PackageControllerProvider());

$app->run();
