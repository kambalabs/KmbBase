<?php
/**
 * @copyright Copyright (c) 2014 Orange Applications for Business
 * @link      http://github.com/multimediabs/kamba for the canonical source repository
 *
 * This file is part of KmbBase.
 *
 * KmbBase is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * KmbBase is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with KmbBase.  If not, see <http://www.gnu.org/licenses/>.
 */
namespace KmbBase\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class GlobalMessenger extends AbstractPlugin
{
    const SUCCESS = 'success';
    const WARNING = 'warning';
    const DANGER  = 'danger';

    /** @var  array */
    protected $messages = [
        self::SUCCESS => [],
        self::WARNING => [],
        self::DANGER => [],
    ];

    /**
     * @param string $type
     * @param string $message
     * @return GlobalMessenger
     */
    public function addMessage($type, $message)
    {
        $this->messages[$type][] = $message;
        return $this;
    }

    /**
     * Get all messages.
     *
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * @param string $message
     * @return GlobalMessenger
     */
    public function addSuccessMessage($message)
    {
        $this->addMessage(static::SUCCESS, $message);
        return $this;
    }

    /**
     * Get success messages.
     *
     * @return array
     */
    public function getSuccessMessages()
    {
        return $this->messages[static::SUCCESS];
    }

    /**
     * @param string $message
     * @return GlobalMessenger
     */
    public function addWarningMessage($message)
    {
        $this->addMessage(static::WARNING, $message);
        return $this;
    }

    /**
     * Get warning messages.
     *
     * @return array
     */
    public function getWarningMessages()
    {
        return $this->messages[static::WARNING];
    }

    /**
     * @param string $message
     * @return GlobalMessenger
     */
    public function addDangerMessage($message)
    {
        $this->addMessage(static::DANGER, $message);
        return $this;
    }

    /**
     * Get danger messages.
     *
     * @return array
     */
    public function getDangerMessages()
    {
        return $this->messages[static::DANGER];
    }
}
