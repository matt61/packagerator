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

        $requiredProperty = new PackageStepProperty();
        $requiredProperty->setPropertyId('AUTH_API_URL');
        $step->addPackageStepProperty($requiredProperty);

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
    }
}