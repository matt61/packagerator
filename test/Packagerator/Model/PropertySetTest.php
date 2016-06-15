<?php

namespace Packagerator\Model\Entity;

use Propel\Runtime\ActiveQuery\Criteria;

class PropertySetTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate(){
        $packageSet = new PropertySet();
        $packageSet->setName(uniqid());
        $packageSet->save();
        $this->assertGreaterThan(0, $packageSet->getId());

        $propertyValue = new PropertyValue();
        $propertyValue->setProperty(PropertyQuery::create()->findOneByIdentifier('AUTH_API_URL'));
        $propertyValue->setValue('http://test.com');
        $packageSet->addPropertyValue($propertyValue);
        $packageSet->save();

        $criteria = new Criteria();
        $criteria->add('property_id', PropertyQuery::create()->findOneByIdentifier('AUTH_API_URL')->getId());

        /** @var PropertyValue $propertyValue */
        $propertyValue = $packageSet->getPropertyValues($criteria)->getFirst();
        $propertyValue->setValue('http://test2.com');

        $packageSet->save();
        $this->assertEquals(3, $packageSet->getVersion());
    }
}