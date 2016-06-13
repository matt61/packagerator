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

$app->get('/info', function () use ($app) {
    phpinfo();
});

$app->get('/package/{id}', function ($id) use ($app) {
    return $app['twig']->render('package/view.twig', Packagerator\PackageQuery::create()->findPK($id)->toArray(TableMap::TYPE_FIELDNAME));
});

$app->get('/package', function () use ($app) {
    return $app['twig']->render('package/form.twig');
});

$app->post('/package', function (Request $request) use ($app) {
    $package = new \Packagerator\Package();
    $package->fromArray($request->request->all(), TableMap::TYPE_FIELDNAME);
    $package->save();
    return $app->redirect('/package/'.$package->getId());
});

$app->run();
