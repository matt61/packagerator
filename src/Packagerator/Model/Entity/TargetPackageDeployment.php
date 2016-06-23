<?php

namespace Packagerator\Model\Entity;

use Packagerator\Model\Entity\Base\TargetPackageDeployment as BaseTargetPackageDeployment;

/**
 * Skeleton subclass for representing a row from the 'target_package_deployment' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class TargetPackageDeployment extends BaseTargetPackageDeployment
{
    public function forJson()
    {
        return [
            "target" => $this->getTarget()->toArray(),
            "package" => $this->getPackage()->toArray(),
            "steps" => $this->getPackage()->stepsToArray()
        ];
    }

}
