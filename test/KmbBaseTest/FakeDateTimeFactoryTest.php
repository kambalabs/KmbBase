<?php
namespace KmbBaseTest;

use KmbBase\FakeDateTimeFactory;

class FakeDateTimeFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function canGetNow()
    {
        $now = new \DateTime();
        $fakeDateTimeFactory = new FakeDateTimeFactory($now);

        $this->assertEquals($now, $fakeDateTimeFactory->now());
    }
}
