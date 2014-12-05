<?php
namespace KmbBaseTest\View\Helper;

use KmbBaseTest\Bootstrap;

class WidgetFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function canCreateHelper()
    {
        $helper = Bootstrap::getServiceManager()->get('ViewHelperManager')->get('widget');

        $this->assertInstanceOf('KmbBase\View\Helper\Widget', $helper);
    }
}
