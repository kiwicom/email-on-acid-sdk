<?php

namespace EmailOnAcid\Tests\Response;

use EmailOnAcid\Response\EmailClientTip;
use PHPUnit\Framework\TestCase;

class EmailClientTipTest extends TestCase
{
	public function testObject()
	{

		$client = 'asdasdoasd';
		$name = 'asdoasoddas';
		$tip = 'asidisdfndsiofbmiodfbdsfbsdfb';

		$clientTip = new EmailClientTip($client, $name, $tip);

		$this->assertSame($client, $clientTip->getClient());
		$this->assertSame($name, $clientTip->getName());
		$this->assertSame($tip, $clientTip->getTip());

	}

}
