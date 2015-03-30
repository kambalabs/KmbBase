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
namespace KmbBase\Listener;

use KmbBase\View\Helper\Widget;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\Controller\ControllerManager;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceManager;

class WidgetViewHelperListener extends AbstractListenerAggregate
{
    protected $priority = -1;

    /**
     * Attach one or more listeners
     *
     * Implementors may add an optional $priority argument; the EventManager
     * implementation will pass this to the aggregate.
     *
     * @param EventManagerInterface $events
     *
     * @return void
     */
    public function attach(EventManagerInterface $events)
    {
        $events->attach(
            MvcEvent::EVENT_RENDER,
            function (MvcEvent $event) {
                /** @var ServiceManager $serviceManager */
                $serviceManager = $event->getTarget()->getServiceManager();
                /** @var ControllerManager $controllerManager */
                $controllerManager = $serviceManager->get('ControllerManager');
                $controller = $controllerManager->get($event->getRouteMatch()->getParam('controller'));
                $viewHelperManager = $serviceManager->get('ViewHelperManager');
                /** @var Widget $widgetViewHelper */
                $widgetViewHelper = $viewHelperManager->get('widget');
                $widgetViewHelper->setController($controller);
            },
            $this->priority
        );
    }
}
