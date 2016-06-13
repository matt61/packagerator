<?php
require_once __DIR__.'/../vendor/autoload.php';
$app = new Silex\Application();
$app->register(new Propel\Silex\PropelServiceProvider(), array(
    'propel.config_file' => __DIR__.'/../config/config.php'
));
$app->get('/hello/{name}', function ($name) use ($app) {

    $q = new Packagerator\PackageQuery();
    $firstPackage = $q->findPK(1);
    return 'Hello '.$app->escape($name);
});
$app->run();
