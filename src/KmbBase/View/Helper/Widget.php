<?php
/**
 * @copyright Copyright (c) 2014 Orange Applications for Business
 * @link      http://github.com/kambalabs for the sources repositories
 *
 * This file is part of Kamba.
 *
 * Kamba is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * Kamba is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Kamba.  If not, see <http://www.gnu.org/licenses/>.
 */
namespace KmbBase\View\Helper;

use KmbBase\Widget\DefaultWidgetAction;
use KmbBase\Widget\WidgetActionInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\DispatchableInterface;
use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;

class Widget extends AbstractHelper
{
    /** @var  array */
    protected $config;

    /** @var  WidgetActionInterface[] */
    protected $actions = [];

    /** @var  ServiceLocatorInterface */
    protected $serviceLocator;

    /** @var  DispatchableInterface */
    protected $controller;

    /**
     * @param string $name
     * @return Widget
     */
    public function __invoke($name)
    {
        $this->actions = [];
        foreach ($this->getWidgetConfigs($name) as $config) {
            $action = isset($config['action']) ? $this->serviceLocator->get($config['action']) : new DefaultWidgetAction();
            $action->setTemplate($config['template']);
            $action->setServiceLocator($this->serviceLocator);
            $action->setController($this->controller);
            $this->actions[] = $action;
        }
        return $this;
    }

    /**
     * @param array $model
     * @return string
     */
    public function render($model = [])
    {
        $content = '';
        foreach ($this->actions as $action) {
            $viewModel = $this->createModel($action->getTemplate(), $model);
            $content .= $this->view->partial($action->call($viewModel));
        }
        return $content;
    }

    /**
     * @param string $name
     * @return array
     */
    public function getWidgetConfigs($name)
    {
        return isset($this->config[$name]) ? $this->config[$name] : [];
    }

    /**
     * @param string $template
     * @param array $model
     * @return ViewModel
     */
    protected function createModel($template, $model)
    {
        $viewModel = new ViewModel($model);
        foreach ($this->view->viewModel()->getCurrent()->getVariables() as $key => $value) {
            $viewModel->setVariable($key, $viewModel->getVariable($key, $value));
        }
        return $viewModel->setTemplate($template);
    }

    /**
     * Set Config.
     *
     * @param array $config
     * @return Widget
     */
    public function setConfig($config)
    {
        $this->config = $config;
        return $this;
    }

    /**
     * Get Config.
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set ServiceLocator.
     *
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return Widget
     */
    public function setServiceLocator($serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }

    /**
     * Get ServiceLocator.
     *
     * @return \Zend\ServiceManager\ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * Set Controller.
     *
     * @param \Zend\Stdlib\DispatchableInterface $controller
     * @return Widget
     */
    public function setController($controller)
    {
        $this->controller = $controller;
        return $this;
    }

    /**
     * Get Controller.
     *
     * @return \Zend\Stdlib\DispatchableInterface
     */
    public function getController()
    {
        return $this->controller;
    }
}
