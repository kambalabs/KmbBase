<?php
namespace KmbBaseTest\Controller\Plugin;

use KmbBase\Controller\Plugin\AbstractWidgetAction;
use KmbBase\Controller\Plugin\Widget;
use KmbBase\Controller\Plugin\WidgetActionInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Model\ViewModel;

class WidgetTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function canRunActions()
    {
        $serviceLocator = new ServiceManager();
        $serviceLocator->setService('FakeWidgetAction', new FakeWidgetAction());
        $widget = new Widget();
        $widget->setServiceLocator($serviceLocator);
        $widget->setConfig([
            'test' => [
                'actions' => [
                    'FakeWidgetAction',
                ],
            ],
        ]);
        $model = new ViewModel();

        $widget('test')->runActions($model);

        $this->assertEquals('bar', $model->getVariable('foo'));
    }
}

class FakeWidgetAction extends AbstractWidgetAction
{
    /**
     * @param ViewModel $model
     * @return WidgetActionInterface
     */
    public function run(ViewModel $model = null)
    {
        $model->setVariable('foo', 'bar');
        return $this;
    }
}
