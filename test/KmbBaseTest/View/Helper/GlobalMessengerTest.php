<?php
namespace KmbBaseTest\View\Helper;

use KmbBase\View\Helper\GlobalMessenger;

class GlobalMessengerTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function canRender()
    {
        $globalMessenger = new GlobalMessenger();
        $globalMessenger->getPluginGlobalMessenger()->addSuccessMessage('Test');

        $this->assertEquals('<ul class="gritter-success"><li>Test</li></ul>', $globalMessenger->render());
    }
}
