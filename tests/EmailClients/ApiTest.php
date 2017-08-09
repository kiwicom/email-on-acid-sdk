<?php

namespace EmailOnAcid\Tests\EmailClients;

use EmailOnAcid\EmailClients\Service;
use EmailOnAcid\Exception\InvalidApiResponseData;
use EmailOnAcid\Response\NewDefaultClients;
use EmailOnAcid\Tests\ApiHelper;
use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase
{
	use ApiHelper;

	public function testGetClients()
	{

		$api = $this->mockEmailClientsApi(
			$this->mockRequestFactory('get'),
			$this->mockServiceFactory('getClients', Service::class, [])
		);

		$clients = $api->getClients();

		$this->assertSame([], $clients);
	}

	public function testGetDefaultClients()
	{

		$clients = ["asdasf", "figig", "kgogo"];
		$api = $this->mockEmailClientsApi(
			$this->mockRequestFactory('get', ['clients' => $clients]),
			$this->mockServiceFactory(null)
		);
		$defaults = $api->getDefaultClients();

		$this->assertSame($clients, $defaults);

		$this->expectException(InvalidApiResponseData::class);

		$api = $this->mockEmailClientsApi(
			$this->mockRequestFactory('get', ['' => $clients]),
			$this->mockServiceFactory(null)
		);
		$defaults = $api->getDefaultClients();

		$this->assertSame($clients, $defaults);

	}

	public function testSetDefaultClients()
	{

		$clients = ["asdasf", "figig", "kgogo"];
		$new_default_clients = new NewDefaultClients($clients, []);
		$api = $api = $this->mockEmailClientsApi(
			$this->mockRequestFactory('put'),
			$this->mockServiceFactory('setDefaultClients', Service::class, $new_default_clients)
		);
		$defaults = $api->setDefaultClients($clients);

		$this->assertSame($clients, $defaults->getClients());
		$this->assertSame([], $defaults->getWarnings());
	}

	public function testGetClientTips()
	{
		$api = $api = $this->mockEmailClientsApi(
			$this->mockRequestFactory('get'),
			$this->mockServiceFactory('getClientTips', Service::class, [])
		);
		$tips = $api->getClientTips('test');

		$this->assertSame([], $tips);

	}


}
