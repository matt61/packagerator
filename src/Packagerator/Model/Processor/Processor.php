<?php
namespace Packagerator\Model\Processor;

use Packagerator\Model\Entity\TargetPackageDeployment;
use Packagerator\Model\Entity\Map\PackageStepTableMap;
use Packagerator\Model\Entity\Target;
use Propel\Runtime\ActiveQuery\Criteria;

abstract class Processor
{
    /**
     * @var Target
     */
    private $target;

    public function __construct(Target $target)
    {
        $this->target = $target;
    }

    public function process()
    {
        foreach($this->getCommands() as $command){
            $this->sendCommand($command);
        }
    }

    /**
     * @param TargetPackageDeployment $deployment
     * @return \Generator
     */
    protected function getCommands()
    {
        foreach($this->target->getDeployments() as $deployment){
            foreach($deployment->getPackage()->getSteps() as $step){
                foreach($step->getExecutions() as $execution){
                    yield $execution->getInput();
                }
            }
        }
    }

    abstract public function sendCommand($commandString);

}