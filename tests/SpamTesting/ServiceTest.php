<?php

namespace EmailOnAcid\SpamTesting;

use EmailOnAcid\Exception\InvalidApiResponseData;
use EmailOnAcid\Response\SpamTestClient;
use EmailOnAcid\Response\Test;
use PHPUnit\Framework\TestCase;

class ServiceTest extends TestCase
{

	/**
	 * @param array $data
	 * @param null $expect_exception
	 * @throws \Exception
	 * @dataProvider provideTestCreateSpamTest
	 */
	public function testCreateSpamTest(array $data, $expect_exception = null)
	{
		$service = $this->getInstance();
		if ($expect_exception) {
			$this->expectException($expect_exception);
		}
		$spam_test = $service->createSpamTest($data);

		$this->assertSame($data['id'], $spam_test->getId());
		if (isset($data['reference_id'])) {
			$this->assertSame($data['reference_id'], $spam_test->getReferenceId());
		}
		if (isset($data['customer_id'])) {
			$this->assertSame($data['customer_id'], $spam_test->getCustomerId());
		}
		if (isset($data['address_list'])) {
			$this->assertSame($data['address_list'], $spam_test->getAddresses());
		}


	}

	private function getInstance()
	{
		return new Service();
	}

	public function provideTestCreateSpamTest()
	{
		return [
			[
				['id' => 'test', 'reference_id' => 'dasdasd', 'customer_id' => 'sdasda', 'address_list' => ['sdasdasd']]
			],
			[
				['id' => 'test']
			],
			[
				[],
				InvalidApiResponseData::class
			],
			[
				['reference_id' => 'dasdasd', 'customer_id' => 'sdasda', 'address_list' => ['sdasdasd']],
				InvalidApiResponseData::class
			],
		];
	}

	/**
	 * @param array $data
	 * @param null $expect_exception
	 * @dataProvider provideTestGetResults
	 */
	public function testGetResults(array $data, $expect_exception = null)
	{
		$service = $this->getInstance();
		if ($expect_exception) {
			$this->expectException($expect_exception);
		}

		$results = $service->getResults($data);

		$this->assertCount(1, $results);
		foreach ($results as $index => $result) {
			$this->assertSame($data[$index]['client'], $results[$index]->getClient());
			$this->assertSame($data[$index]['type'], $results[$index]->getType());
			$this->assertSame($data[$index]['spam'], $results[$index]->getSpam());
			$this->assertSame(json_encode($data[$index]['details']), $results[$index]->getDetails());
		}
	}

	public function provideTestGetResults()
	{
		return [
			[
				[
					['client' => 'tsdf', 'type' => 'fdfsfd', 'spam' => 2, 'details' => ['fdsf']]
				],
			],
			[
				[
					['client' => 'tsdf', 'type' => 'fdfsfd', 'spam' => 1]
				],
				InvalidApiResponseData::class
			],
			[
				[
					['client' => 'tsdf', 'type' => 'fdfsfd']
				],
				InvalidApiResponseData::class
			],
			[
				[
					['client' => 'tsdf']
				],
				InvalidApiResponseData::class
			]
		];
	}

	/**
	 * @param array $data
	 * @param null $expect_exception
	 * @dataProvider provideTestGetClients
	 */
	public function testGetClients(array $data, $expect_exception = null)
	{
		if ($expect_exception) {
			$this->expectException($expect_exception);
		}
		$service = $this->getInstance();

		$clients = $service->getClients($data);
		$this->assertCount(count($data), $clients);

		foreach ($clients as $index => $client) {
			$client_data = $data[$index];

			$this->assertSame($client_data['client'], $client->getClient());
			$this->assertSame($client_data['type'], $client->getType());
			$this->assertSame($client_data['description'], $client->getDescription());

		}
	}

	public function provideTestGetClients()
	{
		return [
			[
				[
					['client' => 'sadd', 'type' => SpamTestClient::SPAM_TEST_TYPE_B2C, 'description' => 'dasdad']
				]
			],
			[
				[
					['client' => 'sadd', 'type' => 'sadad']
				],
				InvalidApiResponseData::class
			],
			[
				[
					['client' => 'sadd']
				],
				InvalidApiResponseData::class
			],
			[
				[]
			]
		];
	}

	public function testGetSpamTests()
	{
		$service = $this->getInstance();

		$time = new \DateTimeImmutable();

		$tags = [
			'tag1' => 'value'
		];

		$headers = [
			'dead' => 'shot'
		];

		$tests = $service->getSpamTests([
			[
				'id'   => 'test',
				'date' => $time->getTimestamp(),
				'type' => Test::TYPE_SPAM
			],
			[
				'id'      => 'test23',
				'date'    => $time->getTimestamp() + 20000,
				'type'    => Test::TYPE_EMAIL,
				'headers' => $headers,
				'tags'    => $tags
			],
		]);
		/** @var Test $firstTest */
		$firstTest = current($tests);

		$this->assertSame(
			'test',
			$firstTest->getId()
		);

		$this->assertSame(
			$time->getTimestamp(),
			$firstTest->getDate()->getTimestamp()
		);

		$this->assertSame(
			Test::TYPE_SPAM,
			$firstTest->getType()
		);

		$this->assertSame(
			[],
			$firstTest->getTags()
		);

		$this->assertSame(
			[],
			$firstTest->getHeaders()
		);
		/** @var Test $secondTest */
		$secondTest = next($tests);

		$this->assertSame(
			$tags,
			$secondTest->getTags()
		);

		$this->assertSame(
			$headers,
			$secondTest->getHeaders()
		);
	}

	/**
	 * @param array $data
	 * @param null $expect_exception
	 * @dataProvider provideTestGetReserveSeedList
	 */
	public function testGetReserveSeedList(array $data, $expect_exception = null)
	{
		if ($expect_exception) {
			$this->expectException($expect_exception);
		}
		$service = $this->getInstance();

		$seed_list = $service->getReserveSeedList($data);

		$this->assertSame($data['key'], $seed_list->getKey());
		$this->assertSame($data['address_list'], $seed_list->getAddressList());

	}

	public function provideTestGetReserveSeedList()
	{
		return [
			[
				['key' => 'sadd', 'address_list' => []]
			],
			[
				['key' => 'sadd'],
				InvalidApiResponseData::class
			],
			[
				[],
				InvalidApiResponseData::class
			],
		];
	}

}
