<?php

namespace EmailOnAcid\EmailTesting;

use EmailOnAcid\Request\EmailTestRequest;
use EmailOnAcid\Request\TestSearchRequest;
use EmailOnAcid\Response\LinkValidation;
use EmailOnAcid\Response\NewEmailTest;
use EmailOnAcid\Response\Test;
use EmailOnAcid\Response\TestContent;
use EmailOnAcid\Response\TestInfo;
use EmailOnAcid\Tests\ApiHelper;
use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase
{
	use ApiHelper;

	public function testCreateEmailTest()
	{
		$email_test = new NewEmailTest('rrr');

		$api = $this->mockEmailTestingApi(
			$this->mockRequestFactory('post'),
			$this->mockServiceFactory('createEmailTest', Service::class, $email_test)
		);

		$this->assertSame($email_test, $api->createEmailTest(new EmailTestRequest('bkbkb', 'jgjgjg')));

	}

	public function testGetEmailTests()
	{
		$tests = [
			new Test('test', new \DateTimeImmutable(), Test::TYPE_SPAM, [], [])
		];

		$search = $this->getMockBuilder(TestSearchRequest::class)->getMock();
		$search->expects($this->once())->method('jsonSerialize')->willReturn($tests);

		$api = $this->mockEmailTestingApi(
			$this->mockRequestFactory('get'),
			$this->mockServiceFactory('getEmailTests', Service::class, $tests)
		);

		$testsResult = $api->getEmailTests($search);

		$this->assertSame($tests, $testsResult);

	}

	public function testGetTestInfo()
	{
		$test_info = new TestInfo(
			'Test',
			new \DateTimeImmutable()
		);

		$api = $this->mockEmailTestingApi(
			$this->mockRequestFactory('get'),
			$this->mockServiceFactory('getEmailTestInfo', Service::class, $test_info)
		);

		$test_info_result = $api->getTestInfo('testik');

		$this->assertSame($test_info, $test_info_result);
	}

	public function testDeleteTest()
	{
		$api = $this->mockEmailTestingApi(
			$this->mockRequestFactory('delete'),
			$service_factory = $this->mockServiceFactory('successResponse', Service::class, null)
		);
		$api->deleteTest('testik');
	}

	public function testGetResults()
	{
		$api = $this->mockEmailTestingApi(
			$this->mockRequestFactory('get'),
			$service_factory = $this->mockServiceFactory('getResults', Service::class, [])
		);

		$results = $api->getResults('testik', 'test');

		$this->assertSame([], $results);

	}

	public function testCreateReprocessScreenshots()
	{
		$api = $this->mockEmailTestingApi(
			$this->mockRequestFactory('put'),
			$this->mockServiceFactory('createReprocessScreenshots', Service::class, [])
		);

		$reprocess_screenshots = $api->createReprocessScreenshots('testik', ['gigig']);

		$this->assertSame([], $reprocess_screenshots);
	}

	public function testGetTestContent()
	{
		$test_content = new TestContent('gg');
		$api = $this->mockEmailTestingApi(
			$this->mockRequestFactory('get'),
			$this->mockServiceFactory('getTestContent', Service::class, $test_content)
		);

		$test_content_result = $api->getTestContent('testik', 'test');

		$this->assertSame($test_content, $test_content_result);

	}

	public function testGetClientCodeAnalysis()
	{
		$api = $this->mockEmailTestingApi(
			$this->mockRequestFactory('get'),
			$this->mockServiceFactory('getClientCodeAnalysis', Service::class, [])
		);

		$this->assertSame([], $api->getClientCodeAnalysis('test', 'client'));
	}

	public function testGetLinkValidation()
	{
		$link_validation = new LinkValidation([], []);
		$api = $this->mockEmailTestingApi(
			$this->mockRequestFactory('get'),
			$this->mockServiceFactory('getLinkValidation', Service::class, $link_validation)
		);

		$link_validation_result = $api->getLinkValidation('test');

		$this->assertSame($link_validation, $link_validation_result);

	}

	public function testCreateLinkValidation()
	{
		$link_validation = new LinkValidation([], []);
		$api = $this->mockEmailTestingApi(
			$this->mockRequestFactory('put'),
			$this->mockServiceFactory('getLinkValidation', Service::class, $link_validation)
		);


		$link_validation_result = $api->createLinkValidation('test');

		$this->assertSame($link_validation, $link_validation_result);
	}

	public function testGetSpamResult()
	{
		$test = [];
		$api = $this->mockEmailTestingApi(
			$this->mockRequestFactory('get'),
			$this->mockServiceFactory('getSpamResult', Service::class, $test)
		);

		$results = $api->getSpamResult('test_id');
		$this->assertSame($test, $results);

	}

	public function testGetSpamSeedList()
	{
		$api = $this->mockEmailTestingApi(
			$this->mockRequestFactory('get'),
			$this->mockServiceFactory(null)
		);

		$spam_seed_list = $api->getSpamSeedList('test');

		$this->assertSame([], $spam_seed_list);
	}


}
