<?php
namespace KmbBaseTest\View\Helper;

use KmbBase\View\Helper\Widget;
use KmbBase\Widget\AbstractWidgetAction;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Model\ViewModel;

class WidgetTest extends \PHPUnit_Framework_TestCase
{
    /** @var  Widget */
    protected $widget;

    protected function setUp()
    {
        $view = $this->getMock('Zend\View\Renderer\PhpRenderer', ['partial', 'viewModel'], [], '', false);
        $view->expects($this->any())
            ->method('partial')
            ->will($this->returnCallback(function ($model = null) {
                $params = '';
                foreach ($model->getVariables() as $key => $value) {
                    $params .= $key . ':' . $value . ' ';
                }
                return 'partial ' . $model->getTemplate() . ' ' . $params;
            }));
        $viewModelHelper = $this->getMock('Zend\View\Helper\ViewModel');
        $viewModelHelper->expects($this->any())->method('getCurrent')->will($this->returnValue(new ViewModel()));
        $view->expects($this->any())->method('viewModel')->will($this->returnValue($viewModelHelper));
        $serviceLocator = new ServiceManager();
        $serviceLocator->setService('FakeWidgetAction', new FakeWidgetAction());
        $this->widget = new Widget();
        $this->widget->setServiceLocator($serviceLocator);
        $this->widget->setView($view);
    }

    /** @test */
    public function canRenderEmptyWidget()
    {
        $content = $this->widget('empty')->render();

        $this->assertEmpty($content);
    }

    /** @test */
    public function canRender()
    {
        $this->widget->setConfig([
            'test' => [
                [
                    'action' => 'FakeWidgetAction',
                    'template' => 'test1',
                ],
                [
                    'template' => 'test2',
                ],
            ],
        ]);

        $content = $this->widget('test')->render();

        $this->assertEquals("partial test1 foo:bar partial test2 ", $content);
    }

    /**
     * @param $name
     * @return Widget
     */
    protected function widget($name)
    {
        $helper = $this->widget;
        return $helper($name);
    }
}

class FakeWidgetAction extends AbstractWidgetAction
{
    /**
     * @param ViewModel $model
     * @return ViewModel
     */
    public function call(ViewModel $model = null)
    {
        return $model->setVariable('foo', 'bar');
    }
}
