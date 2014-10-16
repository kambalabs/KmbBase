<?php
namespace KmbBaseTest\View\Helper;

use KmbBase\View\Helper\Truncate;
use Zend\I18n\Translator\Translator;

class TruncateTest extends \PHPUnit_Framework_TestCase
{
    public function truncate($text, $length = 100, $options = [])
    {
        $helper = new Truncate();
        $helper->setTranslator(new Translator());

        return $helper($text, $length, $options);
    }

    /** @test */
    public function canTruncate()
    {
        $this->assertEquals('Hello h...', $this->truncate('Hello how are you ?', 10));
    }

    /** @test */
    public function canTruncateWithoutWrappingWords()
    {
        $this->assertEquals('Hello...', $this->truncate('Hello how are you ?', 10, ['word-wrap' => false]));
    }
}
