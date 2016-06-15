<?php

namespace Packagerator\Model\Entity;

use Packagerator\Model\Processor\NullProcessor;

class PackageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Package
     */
    private $package;

    /**
     * @var Target
     */
    private $target;

    /**
     * @var PropertySet
     */
    private $propertySet;

    /**
     * @var NullProcessor
     */
    private $processor;

    public function setUp()
    {
        $this->processor = new NullProcessor();
        $this->propertySet = new PropertySet();
        $this->propertySet->setName(uniqid());

        $propertyValue = new PropertyValue();
        $propertyValue->setProperty(PropertyQuery::create()->requireOneByIdentifier('AUTH_API_URL'));
        $propertyValue->setValue(1);
        $this->propertySet->addPropertyValue($propertyValue);

        $this->propertySet->save();

        $this->target = new Target();
        $this->target->setName(uniqid());
        $this->target->setIp(uniqid());
        $this->target->save();

        $this->package = new Package();
        $this->package->setName(uniqid());

        $property = new PackageProperty();
        $property->setProperty(PropertyQuery::create()->requireOneByIdentifier('AUTH_API_URL'));
        $this->package->addPackageProperty($property);

        $property = new PackageProperty();
        $property->setProperty(PropertyQuery::create()->requireOneByIdentifier('MYSQL_URI'));
        $this->package->addPackageProperty($property);

        $step = new PackageStep();
        $step->setName('Install PHP');
        $step->setPackageStepType(PackageStepTypeQuery::create()->findOneByName('install'));

        $execution = new PackageStepExecution();
        $execution->setInput("echo 'foo'");
        $execution->setOutputPattern("/foo/");
        $step->addExecution($execution);

        $execution = new PackageStepExecution();
        $execution->setInput("echo 'bar'");
        $execution->setOutputPattern("/bar/");
        $step->addExecution($execution);

        $this->package->addStep($step);
        $this->package->save();

        parent::setUp();
    }

    public function testDeploy()
    {
        $deployment = $this->target->deploy(
            $this->package,
            $this->propertySet,
            PackageStepTypeQuery::create()->requireOneByName('install'),
            UserQuery::create()->requireOneByEmail('mattward@sparkcentral.com')
        );
        $this->assertEquals($deployment->getPackageId(), $this->package->getId());
        $this->processor->process($deployment);
    }

    public function testDeepCreate(){
        $artifact = new PackageDependancyArtifact();
        $artifact->setName('S3 Download');
        $artifact->setArtifactPath('s3://test');
        $artifact->setChecksum('abc');
        $artifact->setArtifactTypeId(1);

        $this->package->addPackageDependancyArtifact($artifact);
        $this->package->save();
    }
}