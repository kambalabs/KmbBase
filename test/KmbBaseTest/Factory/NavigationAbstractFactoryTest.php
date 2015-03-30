<?php
namespace KmbBaseTest\Factory;

use KmbBase\Factory\NavigationAbstractFactory;
use Zend\ServiceManager\ServiceManager;

class NavigationAbstractFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function cannotCreateUnknownServiceWithName()
    {
        $serviceLocator = new ServiceManager();
        $serviceLocator->setService('Config', []);
        $abstractFactory = new NavigationAbstractFactory();

        $this->assertFalse($abstractFactory->canCreateServiceWithName($serviceLocator, 'unknown', 'unknown'));
    }

    /** @test */
    public function canCreateServiceWithName()
    {
        $serviceLocator = new ServiceManager();
        $serviceLocator->setService('Config', ['navigation' => ['fooNav' => []]]);
        $abstractFactory = new NavigationAbstractFactory();

        $this->assertTrue($abstractFactory->canCreateServiceWithName($serviceLocator, 'fooNav', 'fooNav'));
    }
}
