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

use Zend\I18n\View\Helper\AbstractTranslatorHelper;
use KmbBase\Controller\Plugin\GlobalMessenger as PluginGlobalMessenger;

class GlobalMessenger extends AbstractTranslatorHelper
{
    /** @var  PluginGlobalMessenger */
    protected $pluginGlobalMessenger;

    /** @var  string */
    protected $messageOpenFormat = '<ul%s><li>';

    /** @var  string */
    protected $messageSeparatorString = '</li><li>';

    /** @var  string */
    protected $messageCloseString = '</li></ul>';

    public function render()
    {
        $globalMessenger = $this->getPluginGlobalMessenger();
        $markup  = $this->renderMessages('gritter-success', $globalMessenger->getSuccessMessages()) . PHP_EOL;
        $markup .= $this->renderMessages('gritter-warning', $globalMessenger->getWarningMessages()) . PHP_EOL;
        $markup .= $this->renderMessages('gritter-danger',  $globalMessenger->getDangerMessages())  . PHP_EOL;
        return $markup;
    }

    protected  function renderMessages($class, $messages)
    {
        if (!empty($messages)) {
            $markup  = sprintf($this->getMessageOpenFormat(), ' class="' . $class . '"');
            $markup .= implode(sprintf($this->getMessageSeparatorString(), ' class="' . $class . '"'), $messages);
            $markup .= $this->getMessageCloseString();
            return $markup;
        }
        return '';
    }

    /**
     * Set GlobalMessengerPlugin.
     *
     * @param PluginGlobalMessenger
     * @return GlobalMessenger
     */
    public function setPluginGlobalMessenger($pluginGlobalMessenger)
    {
        $this->pluginGlobalMessenger = $pluginGlobalMessenger;
        return $this;
    }

    /**
     * Get GlobalMessengerPlugin.
     *
     * @return PluginGlobalMessenger
     */
    public function getPluginGlobalMessenger()
    {
        if (null == $this->pluginGlobalMessenger) {
            $this->setPluginGlobalMessenger(new PluginGlobalMessenger());
        }

        return $this->pluginGlobalMessenger;
    }

    /**
     * Set MessageCloseString.
     *
     * @param string $messageCloseString
     * @return GlobalMessenger
     */
    public function setMessageCloseString($messageCloseString)
    {
        $this->messageCloseString = $messageCloseString;
        return $this;
    }

    /**
     * Get MessageCloseString.
     *
     * @return string
     */
    public function getMessageCloseString()
    {
        return $this->messageCloseString;
    }

    /**
     * Set MessageOpenFormat.
     *
     * @param string $messageOpenFormat
     * @return GlobalMessenger
     */
    public function setMessageOpenFormat($messageOpenFormat)
    {
        $this->messageOpenFormat = $messageOpenFormat;
        return $this;
    }

    /**
     * Get MessageOpenFormat.
     *
     * @return string
     */
    public function getMessageOpenFormat()
    {
        return $this->messageOpenFormat;
    }

    /**
     * Set MessageSeparatorString.
     *
     * @param string $messageSeparatorString
     * @return GlobalMessenger
     */
    public function setMessageSeparatorString($messageSeparatorString)
    {
        $this->messageSeparatorString = $messageSeparatorString;
        return $this;
    }

    /**
     * Get MessageSeparatorString.
     *
     * @return string
     */
    public function getMessageSeparatorString()
    {
        return $this->messageSeparatorString;
    }
}
