<?php
namespace KmbBaseTest\Controller\Plugin;

use KmbBase\Controller\Plugin\GlobalMessenger;

class GlobalMessengerTest extends \PHPUnit_Framework_TestCase
{
    /** @var  GlobalMessenger */
    protected $globalMessenger;

    protected function setUp()
    {
        $this->globalMessenger = new GlobalMessenger();
    }

    /** @test */
    public function canGetEmptyMessages()
    {
        $this->assertEquals(
            [
                GlobalMessenger::SUCCESS => [],
                GlobalMessenger::WARNING => [],
                GlobalMessenger::DANGER => []
            ],
            $this->globalMessenger->getMessages()
        );
    }

    /** @test */
    public function canAddMessages()
    {
        $this->globalMessenger
            ->addMessage(GlobalMessenger::SUCCESS, 'message 1')
            ->addMessage(GlobalMessenger::SUCCESS, 'message 2')
            ->addMessage(GlobalMessenger::WARNING, 'message 3')
            ->addMessage(GlobalMessenger::DANGER,  'message 4');

        $this->assertEquals(
            [
                GlobalMessenger::SUCCESS => ['message 1', 'message 2'],
                GlobalMessenger::WARNING => ['message 3'],
                GlobalMessenger::DANGER =>  ['message 4'],
            ],
            $this->globalMessenger->getMessages());
    }

    /** @test */
    public function canGetEmptySuccessMessage()
    {
        $this->assertEquals([], $this->globalMessenger->getSuccessMessages());
    }

    /** @test */
    public function canAddSuccessMessages()
    {
        $this->globalMessenger
            ->addSuccessMessage('message 1')
            ->addSuccessMessage('message 2');

        $this->assertEquals(['message 1', 'message 2'], $this->globalMessenger->getSuccessMessages());
    }

    /** @test */
    public function canGetEmptyWarningMessage()
    {
        $this->assertEquals([], $this->globalMessenger->getWarningMessages());
    }

    /** @test */
    public function canAddWarningMessages()
    {
        $this->globalMessenger
            ->addWarningMessage('message 1')
            ->addWarningMessage('message 2');

        $this->assertEquals(['message 1', 'message 2'], $this->globalMessenger->getWarningMessages());
    }

    /** @test */
    public function canGetEmptyDangerMessage()
    {
        $this->assertEquals([], $this->globalMessenger->getDangerMessages());
    }

    /** @test */
    public function canAddDangerMessages()
    {
        $this->globalMessenger
            ->addDangerMessage('message 1')
            ->addDangerMessage('message 2');

        $this->assertEquals(['message 1', 'message 2'], $this->globalMessenger->getDangerMessages());
    }
}
