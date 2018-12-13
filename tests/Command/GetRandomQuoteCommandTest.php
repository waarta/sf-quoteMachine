<?php

namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class GetRandomQuoteCommandTest extends KernelTestCase
{
    public function testExecute()
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);

        $command = $application->find('app:getRandomQuote');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command' => $command->getName(),
        ));
        // the output of the command in the console
        $output = $commandTester->getDisplay();
        $this->assertContains('Quote', $output);

        $commandTester->execute(array(
            'command' => $command->getName(),
            // pass arguments to the helper
            'category' => 'categ1',
        ));
        // the output of the command in the console
        $output = $commandTester->getDisplay();
        $this->assertContains('categ1', $output);

    }
}
