<?php
namespace KmbBaseTest\View\Helper;

use KmbBase\View\Helper\MarkdownToHtml;

class MarkdownToHtmlTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function canInvoke()
    {
        $helper = new MarkdownToHtml();

        $this->assertEquals('<h2>Class: ntp</h2>' . PHP_EOL, $helper('## Class: ntp'));
    }
}
