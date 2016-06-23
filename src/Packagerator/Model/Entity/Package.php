<?php

namespace Packagerator\Model\Entity;

use Packagerator\Model\Entity\Base\Package as BasePackage;

/**
 * Skeleton subclass for representing a row from the 'package' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Package extends BasePackage
{
    /**
     * @param PropertySet $propertySet
     * @return bool
     */
    public function isValid(PropertySet $propertySet)
    {
        return true;
    }

    public function stepsToArray()
    {
        return array_map(function(PackageStep $step){
            return [
                'id' => $step->getId(),
                'name' => $step->getName(),
                'execute' => array_map(function (PackageStepExecution $execution){
                    return [
                        'input' => $execution->getInput(),
                        'output' => [
                            'type' => ($execution->getOutputCode() ? 'code' : 'pattern'),
                            'value' => ($execution->getOutputCode() ? $execution->getOutputCode() : $execution->getOutputPattern())
                        ]
                    ];
                }, $step->getExecutions()->getArrayCopy())
            ];
        }, $this->getSteps()->getArrayCopy());
    }
}
