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
namespace KmbBaseTest\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class FakeTranslatePlural extends AbstractPlugin
{
    public function __invoke($singular, $plural, $number, $textDomain = 'default', $locale = null)
    {
        return $number > 1 ? $plural : $singular;
    }

    public function __call($method, $args)
    {
        return call_user_func_array([$method], $args);
    }
}
