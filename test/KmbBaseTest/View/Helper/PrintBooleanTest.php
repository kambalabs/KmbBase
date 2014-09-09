<?php
namespace KmbBaseTest\View\Helper;

use KmbBase\View\Helper\PrintBoolean;
use Zend\I18n\Translator\Translator;

class PrintBooleanTest extends \PHPUnit_Framework_TestCase
{
    public function printBoolean($boolean, $format = PrintBoolean::TRUE_FALSE)
    {
        $helper = new PrintBoolean();
        $helper->setTranslator(new Translator());

        return $helper($boolean, $format);
    }

    /** @test */
    public function canInvokeWithTrue()
    {
        $this->assertEquals('true', $this->printBoolean(true));
    }

    /** @test */
    public function canInvokeWithFalse()
    {
        $this->assertEquals('false', $this->printBoolean(false));
    }

    /** @test */
    public function canInvokeWithTrueAndYesNoFormat()
    {
        $this->assertEquals('yes', $this->printBoolean(true, PrintBoolean::YES_NO));
    }

    /** @test */
    public function canInvokeWithFalseAndYesNoFormat()
    {
        $this->assertEquals('no', $this->printBoolean(false, PrintBoolean::YES_NO));
    }

    /** @test */
    public function canInvokeWithTrueAndIntFormat()
    {
        $this->assertEquals(1, $this->printBoolean(true, PrintBoolean::INT));
    }

    /** @test */
    public function canInvokeWithFalseAndIntFormat()
    {
        $this->assertEquals(0, $this->printBoolean(false, PrintBoolean::INT));
    }

    /** @test */
    public function canInvokeWithNull()
    {
        $this->assertEquals('-', $this->printBoolean(null));
    }
}
