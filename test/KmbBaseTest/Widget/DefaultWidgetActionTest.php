<?php
namespace KmbBaseTest\Widget;

use KmbBase\Widget\DefaultWidgetAction;
use Zend\View\Model\ViewModel;

class DefaultWidgetActionTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function canCall()
    {
        $widgetAction = new DefaultWidgetAction();
        $viewModel = new ViewModel(['foo' => 'bar']);

        $this->assertEquals($viewModel, $widgetAction->call($viewModel));
    }
}
