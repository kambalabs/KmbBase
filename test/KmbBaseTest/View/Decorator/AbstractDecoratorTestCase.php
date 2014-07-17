<?php
namespace KmbBaseTest\View\Decorator;

use KmbBaseTest\View\Helper\FakeEscapeHtmlAttrHelper;
use KmbBaseTest\View\Helper\FakeEscapeHtmlHelper;
use KmbBaseTest\View\Helper\FakeTranslateHelper;
use KmbBaseTest\View\Helper\FakeUrlHelper;
use GtnDataTables\View\AbstractDecorator;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\HelperPluginManager;

abstract class AbstractDecoratorTestCase extends \PHPUnit_Framework_TestCase
{
    /** @var AbstractDecorator */
    protected $decorator;

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return HelperPluginManager
     */
    protected function getViewHelperManager(ServiceLocatorInterface $serviceLocator)
    {
        /** @var HelperPluginManager $viewHelperManager */
        $viewHelperManager = $serviceLocator->get('ViewHelperManager');
        $viewHelperManager->setAllowOverride(true);
        $viewHelperManager->setService('translate', new FakeTranslateHelper());
        $viewHelperManager->setService('escapeHtml', new FakeEscapeHtmlHelper());
        $viewHelperManager->setService('escapeHtmlAttr', new FakeEscapeHtmlAttrHelper());
        $viewHelperManager->setService('url', new FakeUrlHelper());
        return $viewHelperManager;
    }
}
