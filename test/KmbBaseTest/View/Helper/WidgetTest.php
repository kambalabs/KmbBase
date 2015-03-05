<?php
namespace KmbBaseTest\View\Helper;

use KmbBase\View\Helper\Widget;

class WidgetTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function canRender()
    {
        $view = $this->getMock('Zend\View\Renderer\PhpRenderer', ['partial'], [], '', false);
        $view->expects($this->any())
            ->method('partial')
            ->will($this->returnCallback(function ($partial) {
                return 'partial ' . $partial . ' ';
            }));
        $widget = new Widget();
        $widget->setView($view);
        $widget->setConfig([
            'test' => [
                'partials' => [
                    'test1',
                    'test2'
                ],
            ],
        ]);

        $content = $widget('test')->render();

        $this->assertEquals('partial test1 partial test2 ', $content);
    }
}
