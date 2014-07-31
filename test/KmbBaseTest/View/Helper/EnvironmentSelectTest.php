<?php
namespace KmbBaseTest\View\Helper;

use KmbBase\View\Helper\EnvironmentSelect;

class EnvironmentSelectTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function canInvoke()
    {
        $helper = new EnvironmentSelect();

        $this->assertEquals('', $helper());
    }
}
