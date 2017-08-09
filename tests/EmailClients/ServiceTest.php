<?php

namespace EmailOnAcid\Tests\EmailClients;

use EmailOnAcid\EmailClients\Service;
use EmailOnAcid\Exception\InvalidApiResponseData;
use PHPUnit\Framework\TestCase;

class ServiceTest extends TestCase
{


	public function testGetClients()
	{
		$id = 'asdagrgwre';
		$os = 'sadfigig';
		$category = 'vbidfo';
		$client = 'fdodfoi';

		$testData = ['clients' => [
			[
				'id'       => $id,
				'os'       => $os,
				'category' => $category,
				'client'   => $client
			]
		]];

		$service = $this->getInstance();

		$clients = $service->getClients($testData);

		$this->assertSame(1, count($clients));
		$this->assertSame($id, $clients[0]->getId());
		$this->assertSame($os, $clients[0]->getOs());
		$this->assertSame($category, $clients[0]->getCategory());
		$this->assertSame($client, $clients[0]->getClient());
		$this->assertSame(false, $clients[0]->isDefault());
		$this->assertSame(false, $clients[0]->isFree());
		$this->assertSame(false, $clients[0]->isImageBlocking());
		$this->assertSame(false, $clients[0]->isRotate());

		$testData = ['clients' => [
			[
				'id'             => $id,
				'os'             => $os,
				'category'       => $category,
				'client'         => $client,
				'rotate'         => true,
				'image_blocking' => true
			]
		]];

		$service = $this->getInstance();
		$clients = $service->getClients($testData);

		$this->assertSame(1, count($clients));
		$this->assertSame($id, $clients[0]->getId());
		$this->assertSame($os, $clients[0]->getOs());
		$this->assertSame($category, $clients[0]->getCategory());
		$this->assertSame($client, $clients[0]->getClient());
		$this->assertSame(false, $clients[0]->isDefault());
		$this->assertSame(false, $clients[0]->isFree());
		$this->assertSame(true, $clients[0]->isImageBlocking());
		$this->assertSame(true, $clients[0]->isRotate());

		$this->expectException(InvalidApiResponseData::class);

		$clients = $service->getClients([]);

	}

	public function getInstance(): Service
	{
		return new Service();
	}

	public function testSetDefaultClients()
	{
		$service = $this->getInstance();

		$responseData = [];

		$response = $service->setDefaultClients($responseData);
		$this->assertSame($responseData, $response->getClients());
		$this->assertSame($responseData, $response->getWarnings());

		$responseData = [
			'clients'  => [
				'saoaosoasd', 'dfsgodfodfg', 'fgogogo'
			],
			'warnings' => [
				'aodsood', 'fdofofoi'
			]
		];

		$response = $service->setDefaultClients($responseData);

		$this->assertSame($responseData['clients'], $response->getClients());
		$this->assertSame($responseData['warnings'], $response->getWarnings());


	}

	public function testGetClientTips()
	{

		$service = $this->getInstance();

		$data = [
			'client' => 'test',
			'tips'   => [
				[
					'name' => 'name',
					'tip'  => 'dip'
				]
			]
		];

		$tips = $service->getClientTips($data);

		$this->assertCount(1, $tips);
		foreach ($tips as $index => $tip) {
			$this->assertSame($data['client'], $tip->getClient());
			$this->assertSame($data['tips'][$index]['name'], $tip->getName());
			$this->assertSame($data['tips'][$index]['tip'], $tip->getTip());
		}
	}

	public function testGetClientTipsInvalid()
	{

		$service = $this->getInstance();

		$this->expectException(InvalidApiResponseData::class);

		$tips = $service->getClientTips([
			'tips' => [
				[
					'name' => 'name',
					'tip'  => 'dip'
				]
			]
		]);
	}

	public function testGetClientTipsInvalid2()
	{

		$service = $this->getInstance();

		$this->expectException(InvalidApiResponseData::class);

		$tips = $service->getClientTips([
			'client' => [
				[
					'name' => 'name',
					'tip'  => 'dip'
				]
			]
		]);
	}

}
