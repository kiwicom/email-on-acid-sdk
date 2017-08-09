<?php

namespace EmailOnAcid\Tests\Tests;



use EmailOnAcid\Request\TestSearchRequest;


use EmailOnAcid\Tests\ApiHelper;
use EmailOnAcid\Tests\Service;

use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase
{
	use ApiHelper;

	public function testGetTests()
	{

		$api = $this->mockTestsApi(
			$this->mockRequestFactory('get'),
			$this->mockServiceFactory(
				'getTests',Service::class,[]
			)
		);

		$search = $this->getMockBuilder(TestSearchRequest::class)->getMock();
		$search->expects($this->once())->method('jsonSerialize')->willReturn([]);

		$testsResult = $api->getTests($search);

		$this->assertSame([],$testsResult);

	}

}
