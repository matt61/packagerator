<?php
require_once __DIR__.'/../vendor/autoload.php';

use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\JsonResponse;
use \Propel\Runtime\Map\TableMap;
use \Symfony\Component\HttpKernel\HttpKernelInterface;
use \Packagerator\Model\Entity\TargetPackageDeploymentQuery;

$app = new Silex\Application();
$app->register(new Propel\Silex\PropelServiceProvider(), array(
    'propel.config_file' => __DIR__.'/../config/config.php'
));
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../view',
));
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());


$app->get('/deploy/{id}', function ($id) use ($app) {
    $deployment = TargetPackageDeploymentQuery::create()->requireOneById($id);
    return new JsonResponse($deployment->forJson());
});

$app->mount('/package', new \Packagerator\Controller\PackageControllerProvider());

$app->run();
