<?php

namespace Packagerator\Model\Entity;

use Packagerator\Model\Entity\Base\Target as BaseTarget;

/**
 * Skeleton subclass for representing a row from the 'target' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Target extends BaseTarget
{
    public function deploy(Package $package, PropertySet $propertySet)
    {
        if ($package->isValid($propertySet)){
            $deployment = new TargetPackageDeployment();
            $deployment->setPackage($package);
            $deployment->setPropertySet($propertySet);
            $deployment->setTarget($this);
            $deployment->setTargetPackageStatus(TargetPackageStatusQuery::create()->findOneByName('waiting'));
            $deployment->save();
            return $deployment;
        }
    }

}
