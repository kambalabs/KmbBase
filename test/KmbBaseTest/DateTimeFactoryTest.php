<?php
namespace KmbBaseTest;

use KmbBase\DateTimeFactory;

class DateTimeFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function canGetNow()
    {
        $dateTimeFactory = new DateTimeFactory();

        $this->assertInstanceOf('\DateTime', $dateTimeFactory->now());
    }
}
