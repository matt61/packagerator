<?php
/**
 * Created by IntelliJ IDEA.
 * User: matt
 * Date: 6/14/16
 * Time: 8:52 PM
 */

namespace Packagerator\Model\Processor;


use Packagerator\Model\Entity\Base\TargetPackageDeployment;
use Packagerator\Model\Entity\Map\PackageStepTableMap;
use Packagerator\Model\Entity\PackageStep;
use Packagerator\Model\Entity\PackageStepQuery;
use Propel\Runtime\ActiveQuery\Criteria;

class NullProcessor
{
    public function process(TargetPackageDeployment $deployment)
    {
        $criteria = new Criteria();
        $criteria->add(PackageStepTableMap::COL_PACKAGE_STEP_TYPE_ID, $deployment->getPackageStepTypeId());
        foreach($deployment->getPackage()->getSteps($criteria) as $step){
            foreach($step->getExecutions() as $execution){
                $this->sendCommand($execution->getInput());
            }
        }
    }

    private function sendCommand($command){
        echo $command;
    }

}