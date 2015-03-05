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
namespace KmbBase\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Model\ViewModel;

class Widget extends AbstractPlugin
{
    /** @var  string */
    protected $widgetName;

    /** @var  array */
    protected $config;

    /** @var  ServiceLocatorInterface */
    protected $serviceLocator;

    /**
     * @param ViewModel $model
     * @return ViewModel
     */
    public function runActions(ViewModel $model)
    {
        foreach ($this->getActions($this->widgetName) as $action) {
            /** @var WidgetActionInterface $action */
            $action->run($model);
        }
        return $model;
    }

    /**
     * @param string $name
     * @return Widget
     */
    public function __invoke($name)
    {
        if ($name !== null) {
            $this->setWidgetName($name);
        }
        return $this;
    }

    /**
     * Set service locator
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return Widget
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }

    /**
     * Get service locator
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * Set WidgetName.
     *
     * @param string $widgetName
     * @return Widget
     */
    public function setWidgetName($widgetName)
    {
        $this->widgetName = $widgetName;
        return $this;
    }

    /**
     * Get WidgetName.
     *
     * @return string
     */
    public function getWidgetName()
    {
        return $this->widgetName;
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
     * @param $widgetName
     * @return WidgetActionInterface[]
     */
    public function getActions($widgetName)
    {
        if (!array_key_exists($widgetName, $this->config)) {
            return [];
        }
        return array_map(function ($service) {
            return $this->getServiceLocator()->get($service);
        }, $this->config[$widgetName]['actions']);
    }
}
