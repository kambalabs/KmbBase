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

class PrintBoolean extends AbstractTranslatorHelper
{
    const TRUE_FALSE = 'true-false';
    const YES_NO = 'yes-no';
    const INT = 'int';

    public function __invoke($boolean, $format = self::TRUE_FALSE)
    {
        $translator = $this->getTranslator();

        if ($boolean === null) {
            return '-';
        }

        if ($format === self::YES_NO) {
            return $boolean ? $translator->translate('yes') : $translator->translate('no');
        }

        if ($format === self::INT) {
            return $boolean ? 1 : 0;
        }

        return $boolean ? $translator->translate('true') : $translator->translate('false');
    }
}
