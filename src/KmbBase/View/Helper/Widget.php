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

use Zend\View\Helper\AbstractHelper;

class Widget extends AbstractHelper
{
    /** @var  array */
    protected $config;

    /** @var  string */
    protected $widgetName;

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
     * @param array  $model
     * @return string
     */
    public function render($model = [])
    {
        $content = '';
        foreach ($this->getPartials() as $partial) {
            $content .= $this->view->partial($partial, $model);
        }
        return $content;
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
     * Get partials of current widget name.
     *
     * @return array
     */
    public function getPartials()
    {
        if (isset($this->config[$this->widgetName]['partials'])) {
            return $this->config[$this->widgetName]['partials'];
        }
        return [];
    }
}
