<?php

namespace EmailOnAcid\SpamTesting;

use EmailOnAcid\Request\SpamTestRequest;
use EmailOnAcid\Request\TestSearchRequest;
use EmailOnAcid\Response\NewSpamTest;
use EmailOnAcid\Response\ReserveSeedList;
use EmailOnAcid\Tests\ApiHelper;
use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase
{
	use ApiHelper;

	public function testCreateSpamTest()
	{
		$new_spam_test = new NewSpamTest('test');
		$spam_test = $this->getMockBuilder(SpamTestRequest::class)->disableOriginalConstructor()->onlyMethods(['jsonSerialize'])->getMock();
		$spam_test->expects($this->once())->method('jsonSerialize');

		$api = $this->mockSpamTestingApi(
			$this->mockRequestFactory('post'),
			$this->mockServiceFactory('createSpamTest', Service::class, $new_spam_test)
		);

		$new_spam_test_result = $api->createSpamTest($spam_test);

		$this->assertSame($new_spam_test, $new_spam_test_result);

	}

	public function testGetClients()
	{
		$api = $this->mockSpamTestingApi(
			$this->mockRequestFactory('get'),
			$this->mockServiceFactory('getClients', Service::class, [])
		);

		$clients = $api->getClients();

		$this->assertSame([], $clients);

	}

	public function testGetSpamTests()
	{
		$api = $this->mockSpamTestingApi(
			$this->mockRequestFactory('get'),
			$this->mockServiceFactory('getSpamTests', Service::class, [])
		);


		$search = $this->getMockBuilder(TestSearchRequest::class)->getMock();
		$search->expects($this->once())->method('jsonSerialize')->willReturn([]);

		$tests = $api->getSpamTests($search);

		$this->assertSame([], $tests);
	}

	public function testGetResults()
	{
		$api = $this->mockSpamTestingApi(
			$this->mockRequestFactory('get'),
			$this->mockServiceFactory('getResults', Service::class, [])
		);

		$results = $api->getResults('test_id');

		$this->assertSame([], $results);
	}

	public function testDeleteTest()
	{
		$api = $this->mockSpamTestingApi(
			$this->mockRequestFactory('delete'),
			$this->mockServiceFactory('successResponse', Service::class, null)
		);
		$this->assertNull(
			$api->deleteTest('test')
		);
	}

	public function testGetSeedList()
	{
		$api = $this->mockSpamTestingApi(
			$this->mockRequestFactory('get'),
			$this->mockServiceFactory(null)
		);

		$seed_list = $api->getSeedList('test');

		$this->assertSame([], $seed_list);
	}

	public function testGetReserveSeedList()
	{
		$reserve_seed_list = new ReserveSeedList('fke', []);

		$api = $this->mockSpamTestingApi(
			$this->mockRequestFactory('get'),
			$this->mockServiceFactory('getReserveSeedList', Service::class, $reserve_seed_list)
		);

		$reserve_seed_list_result = $api->getReserveSeedList();

		$this->assertSame($reserve_seed_list, $reserve_seed_list_result);
	}

}
