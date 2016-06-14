<?php

namespace Packagerator\Model;

class PackageTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate(){
        $package = new Package();
        $package->setName(uniqid());
        $package->save();
        $this->assertGreaterThan(0, $package->getId());
    }

    public function testDeepCreate(){
        $package = new Package();
        $package->setName(uniqid());

        $artifact = new PackageDependancyArtifact();
        $artifact->setName('S3 Download');
        $artifact->setArtifactPath('s3://test');
        $artifact->setChecksum('abc');
        $artifact->setArtifactTypeId(1);

        $step = new PackageStep();
        $step->setName('Install nginx');
        $step->setPackageStepTypeId(1);

        $requiredProperty = new PackageProperty();
        $requiredProperty->setPropertyId('AUTH_API_URL');
        $package->addPackageProperty($requiredProperty);

        $execution = new PackageStepExecution();
        $execution->setInput("echo 'test");
        $execution->setOutputCode(1);
        $step->addPackageStepExecution($execution);

        $package->addPackageDependancyArtifact($artifact);
        $package->addStep($step);
        $package->save();

        $step = new PackageStep();
        $step->setName('Install php');
        $step->setPackageStepTypeId(1);

        $execution = new PackageStepExecution();
        $execution->setInput("echo 'test2");
        $execution->setOutputCode(1);
        $step->addPackageStepExecution($execution);

        $package->addStep($step);
        $package->save();

        $this->assertEquals(2, $package->getVersion());

        $target = new Target();
        $target->setName(uniqid());
        $target->setIp(uniqid());
        $target->save();

        $propertySet = new PropertySet();
        $propertySet->setName(uniqid());
        $propertyValue = new PropertyValue();
        $propertyValue->setPropertyId('AUTH_API_URL');
        $propertyValue->setValue(1);
        $propertySet->addPropertyValue($propertyValue);
        $propertySet->save();

        $deployment = new TargetPackageDeployment();
        $deployment->setPackage($package);
        $deployment->setPropertySet($propertySet);
        $deployment->setTargetPackageStatusId(1);

        $target->addTargetPackageDeployment($deployment);
        $target->save();

    }
}