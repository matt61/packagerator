<?php

namespace Packagerator\Model;

use Propel\Runtime\ActiveQuery\Criteria;

class PropertySetTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate(){
        $packageSet = new PropertySet();
        $packageSet->setName(uniqid());
        $packageSet->save();
        $this->assertGreaterThan(0, $packageSet->getId());

        $propertyValue = new PropertyValue();
        $propertyValue->setPropertyId('AUTH_API_URL');
        $propertyValue->setValue('http://test.com');
        $packageSet->addPropertyValue($propertyValue);
        $packageSet->save();

        $criteria = new Criteria();
        $criteria->add('property_id', 'AUTH_API_URL');

        /** @var PropertyValue $propertyValue */
        $propertyValue = $packageSet->getPropertyValues($criteria)->getFirst();
        $propertyValue->setValue('http://test2.com');

        $packageSet->save();
        $this->assertEquals(3, $packageSet->getVersion());
    }
}