<?php
namespace KmbBaseTest\View\Helper;

use KmbBase\View\Helper\Widget;
use KmbBaseTest\Bootstrap;

class WidgetFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function canCreateHelper()
    {
        /** @var Widget $helper */
        $helper = Bootstrap::getServiceManager()->get('ViewHelperManager')->get('widget');

        $this->assertInstanceOf('KmbBase\View\Helper\Widget', $helper);
        $this->assertEquals([
            'fake' => [
                'partials' => [
                    'fake.phtml',
                ]
            ]
        ], $helper->getConfig());
    }
}
