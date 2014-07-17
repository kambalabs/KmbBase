<?php
/**
 * @copyright Copyright (c) 2014 Orange Applications for Business
 * @link      http://github.com/multimediabs/kamba for the canonical source repository
 *
 * This file is part of kamba.
 *
 * kamba is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * kamba is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with kamba.  If not, see <http://www.gnu.org/licenses/>.
 */
namespace KmbBaseTest\View\Helper;

use Zend\View\Helper\AbstractHelper;

class FakeUrlHelper extends AbstractHelper
{
    public function __invoke($name, $params = array(), $options = array(), $reuseMatchedParams = false)
    {
        $query = '';
        if (isset($options['query'])) {
            $list = array();
            foreach ($options['query'] as $param => $value) {
                $list[] = "$param=$value";
            }
            $query = '?' . implode('&', $list);
        }
        switch ($name) {
            case 'server':
                return '/servers/' . $params['hostname'] . $query;
            case 'servers':
                return '/servers/';
            case 'puppet':
                return '/puppet/' . $params['controller'];
        }
        return '';
    }
}
