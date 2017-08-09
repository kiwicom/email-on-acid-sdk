<?php

namespace EmailOnAcid\Tests\EmailClients;

use EmailOnAcid\Response\NewDefaultClients;
use PHPUnit\Framework\TestCase;

class NewDefaultClientsTest extends TestCase
{
	public function testObject()
	{
		$clients = ['igigigig', 'goog'];
		$warning = ['ggog'];

		$response = new NewDefaultClients($clients, $warning);

		$this->assertSame($clients, $response->getClients());
		$this->assertSame($warning, $response->getWarnings());

	}

}
