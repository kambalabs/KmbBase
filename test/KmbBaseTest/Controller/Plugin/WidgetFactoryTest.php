<?php
namespace KmbBaseTest\Controller\Plugin;

use KmbBase\Controller\Plugin\Widget;
use KmbBaseTest\Bootstrap;

class WidgetFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function canCreateService()
    {
        $serviceManager = Bootstrap::getServiceManager();
        /** @var Widget $plugin */
        $plugin = $serviceManager->get('ControllerPluginManager')->get('widget');

        $this->assertInstanceOf('KmbBase\Controller\Plugin\Widget', $plugin);
        $this->assertEquals($serviceManager, $plugin->getServiceLocator());
        $this->assertEquals([
            'fake' => [
                'actions' => [
                    'FakeWidgetAction'
                ]
            ]
        ], $plugin->getConfig());
    }
}
