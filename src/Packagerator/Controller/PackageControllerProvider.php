<?php
namespace Packagerator\Controller;

use Packagerator\Model\Entity\Package;
use Packagerator\Model\Entity\PackageQuery;
use Propel\Runtime\Map\TableMap;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class PackageControllerProvider implements \Silex\ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get('/{id}', function ($id) use ($app) {
            $package = PackageQuery::create()->requireOneById($id);
            return $app['twig']->render('package/form.twig', $package);
        })->bind('package_edit');

        $controllers->get('/', function () use ($app) {
            return $app['twig']->render('package/form.twig');
        });

        $controllers->post('/', function (Request $request) use ($app) {
            $package = new Package();
            $package->fromArray($request->request->all(), TableMap::TYPE_FIELDNAME);
            $package->save();
            return $app->redirect($app['url_generator']->generate('package_view', array('id' => $package->getId())));
        });

        return $controllers;
    }
}