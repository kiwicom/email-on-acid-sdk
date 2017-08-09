<?php

namespace EmailOnAcid\Tests\EmailTesting;

use EmailOnAcid\EmailTesting\Service;
use EmailOnAcid\Exception\InvalidApiResponseData;
use EmailOnAcid\Response\EmailClientTestResult;
use EmailOnAcid\Response\Test;
use EmailOnAcid\Response\TestContent;
use EmailOnAcid\Response\TestInfo;
use PHPUnit\Framework\TestCase;

class ServiceTest extends TestCase
{
	public function testCreateEmailTest()
	{
		$test_id = 'fogiig';
		$reference_id = "123ABC";
		$customer_id = "1";

		$spam_id = "sidiig";
		$addresses = [
			"spam_address1@example.com",
			"spam_address2@example.com"
		];
		$test = [
			"id"           => $test_id,
			"reference_id" => $reference_id,
			"customer_id"  => $customer_id,
			"spam"         => [
				"key"          => $spam_id,
				"address_list" => $addresses
			]
		];

		$service = $this->getInstance();
		$newTestResponse = $service->createEmailTest($test);

		$this->assertSame($test_id, $newTestResponse->getId());
		$this->assertSame($reference_id, $newTestResponse->getReferenceId());
		$this->assertSame($customer_id, $newTestResponse->getCustomerId());
		$this->assertSame($spam_id, $newTestResponse->getSpam()->getId());

		$test_id = 'asdggg';

		$test = [
			"id" => $test_id
		];
		$newTestResponse = $service->createEmailTest($test);

		$this->assertSame($test_id, $newTestResponse->getId());

		try {
			$service->createEmailTest([]);
			$this->fail('Invalid data provided , should fail');
		} catch (InvalidApiResponseData $exception) {

		}
	}

	/**
	 * @return Service
	 */
	private function getInstance(): Service
	{
		return new Service();
	}

	public function testGetEmailTests()
	{

		$service = $this->getInstance();

		$time = new \DateTimeImmutable();

		$tags = [
			'tag1' => 'value'
		];

		$headers = [
			'dead' => 'shot'
		];

		$tests = $service->getEmailTests([
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

	public function testGetEmailTestInfo()
	{
		$service = $this->getInstance();

		$data = [
			'subject' => 'oleee'
		];
		try {
			$service->getEmailTestInfo($data);
			$this->fail('Should fail due incomplete data');
		} catch (InvalidApiResponseData $exception) {
			$data['date'] = 123345;
			$data['bounced'] = ['sadsda', 'gifgiifg'];
			$data['completed'] = ['sdosada', 'gigigifg'];
			$data['processing'] = ['doiis', 'gigig'];
			$test_info = $service->getEmailTestInfo($data);
		}
		$this->assertInstanceOf(TestInfo::class, $test_info);

		$this->assertSame($data['subject'], $test_info->getSubject());
		$this->assertSame($data['date'], $test_info->getDate()->getTimestamp());
		$this->assertSame($data['completed'], $test_info->getCompleted());
		$this->assertSame($data['processing'], $test_info->getProcessing());
		$this->assertSame($data['bounced'], $test_info->getBounced());

	}

	/**
	 * @param array $test_data
	 * @param null $expected_exception
	 * @dataProvider providetestGetResults()
	 */
	public function testGetResults(array $test_data, $expected_exception = null)
	{
		$service = $this->getInstance();
		if ($expected_exception) {
			$this->expectException($expected_exception);
		}
		$results = $service->getResults($test_data);

		$this->assertSame(1, count($results));

		/** @var EmailClientTestResult $result */
		$result = $results[0];

		$this->assertSame($result->getId(), $test_data[0]['id']);
		$this->assertSame($result->getDisplayName(), $test_data[0]['display_name']);
		$this->assertSame($result->getClient(), $test_data[0]['client']);
		$this->assertSame($result->getOs(), $test_data[0]['os']);
		$this->assertSame($result->getCategory(), $test_data[0]['category']);
		$this->assertSame($result->getStatus(), $test_data[0]['status']);
		$this->assertSame(count($test_data[0]['screenshots']), count($result->getScreenshots()));

	}

	public function providetestGetResults()
	{
		return [
			[
				[
					[
						'id'             => 'tstst',
						'display_name'   => 'sdadad',
						'client'         => 'sadasd',
						'os'             => 'asdasdsad',
						'category'       => 'adasdsad',
						'screenshots'    => [
							'tsasad' => 'asdasdads',
							'tasdad' => 'asgdgsdf'
						],
						'status'         => EmailClientTestResult::STATUS_COMPLETED,
						'status_details' => [
							'submitted' => 1234124
						]
					]
				],
				null
			],
			[
				[
					[
						'id'             => 'tstst',
						'display_name'   => 'sdadad',
						'client'         => 'sadasd',
						'os'             => 'asdasdsad',
						'category'       => 'adasdsad',
						'screenshots'    => [
							'tsasad' => 'asdasdads',
							'tasdad' => 'asgdgsdf'
						],
						'status_details' => [
							'submitted' => 1234124
						]
					]
				],
				InvalidApiResponseData::class
			],
			[
				[
					[
						'id'             => 'tstst',
						'display_name'   => 'sdadad',
						'client'         => 'sadasd',
						'os'             => 'asdasdsad',
						'category'       => 'adasdsad',
						'status'         => EmailClientTestResult::STATUS_COMPLETED,
						'status_details' => [
							'submitted' => 1234124
						]
					]
				],
				InvalidApiResponseData::class
			],
			[
				[
					[
						'id'             => 'tstst',
						'display_name'   => 'sdadad',
						'client'         => 'sadasd',
						'category'       => 'adasdsad',
						'screenshots'    => [
							'tsasad' => 'asdasdads',
							'tasdad' => 'asgdgsdf'
						],
						'status'         => EmailClientTestResult::STATUS_COMPLETED,
						'status_details' => [
							'submitted' => 1234124
						]
					]
				],
				InvalidApiResponseData::class
			],
			[
				[
					[
						'id'             => 'tstst',
						'display_name'   => 'sdadad',
						'os'             => 'asdasdsad',
						'category'       => 'adasdsad',
						'screenshots'    => [
							'tsasad' => 'asdasdads',
							'tasdad' => 'asgdgsdf'
						],
						'status'         => EmailClientTestResult::STATUS_COMPLETED,
						'status_details' => [
							'submitted' => 1234124
						]
					]
				],
				InvalidApiResponseData::class
			],
			[
				[
					[
						'display_name'   => 'sdadad',
						'client'         => 'sadasd',
						'os'             => 'asdasdsad',
						'category'       => 'adasdsad',
						'screenshots'    => [
							'tsasad' => 'asdasdads',
							'tasdad' => 'asgdgsdf'
						],
						'status'         => EmailClientTestResult::STATUS_COMPLETED,
						'status_details' => [
							'submitted' => 1234124
						]
					]
				],
				InvalidApiResponseData::class
			],
			[
				[
					[
						'id'             => 'tstst',
						'client'         => 'sadasd',
						'os'             => 'asdasdsad',
						'category'       => 'adasdsad',
						'screenshots'    => [
							'tsasad' => 'asdasdads',
							'tasdad' => 'asgdgsdf'
						],
						'status'         => EmailClientTestResult::STATUS_COMPLETED,
						'status_details' => [
							'submitted' => 1234124
						]
					]
				],
				InvalidApiResponseData::class
			]
		];
	}

	/**
	 * @param array $data
	 * @param null $expect_exception
	 * @dataProvider provideTestCreateReprocessScreenshots
	 */
	public function testCreateReprocessScreenshots(array $data, $expect_exception = null)
	{
		if ($expect_exception) {
			$this->expectException($expect_exception);
		}
		$service = $this->getInstance();

		$screenshotsReprocess = $service->createReprocessScreenshots($data);

		$this->assertCount(count($data), $screenshotsReprocess);

		foreach ($data as $client_id => $values) {
			$screenshotReprocess = $screenshotsReprocess[$client_id];

			$this->assertSame($client_id, $screenshotReprocess->getClientId());
			$this->assertSame($values['success'], $screenshotReprocess->isSuccess());
			$this->assertSame($values['remaining_reprocesses'], $screenshotReprocess->getRemainingReprocesses());
			$this->assertSame($values['regional'], $screenshotReprocess->isRegional());
			if (isset($values['reason'])) {
				$this->assertSame($values['reason'], $screenshotReprocess->getReason());
			}
		}

	}

	public function provideTestCreateReprocessScreenshots()
	{
		return [
			[
				[]
			],
			[
				['fak' => ['success' => true]],
				InvalidApiResponseData::class
			],
			[
				['fak' => ['success' => true, 'remaining_reprocesses' => 1]],
				InvalidApiResponseData::class
			],
			[
				['fat' => ['success' => true, 'remaining_reprocesses' => 1, 'regional' => false]]
			],
			[
				['fat' => ['success' => false, 'remaining_reprocesses' => 1, 'regional' => false, 'reason' => 'bla bla']]
			],
		];
	}

	/**
	 * @param array $data
	 * @param null $expect_exception
	 * @dataProvider provideTestGetTestContent
	 */
	public function testGetTestContent(array $data, $expect_exception = null)
	{
		$service = $this->getInstance();
		if ($expect_exception) {
			$this->expectException($expect_exception);
		}
		$test_content = $service->getTestContent($data);

		$this->assertInstanceOf(TestContent::class, $test_content);
		$this->assertSame($data['content'], $test_content->getContent());

	}

	public function provideTestGetTestContent()
	{
		return [
			[
				['content' => '<html>Ojojoj</html>']
			],
			[
				['contentx' => '<html>Ojojoj</html>'],
				InvalidApiResponseData::class
			],
			[
				[],
				InvalidApiResponseData::class
			],
		];
	}

	/**
	 * @param array $data
	 * @param null $expect_exception
	 * @dataProvider provideTestGetClientCodeAnalysis
	 */
	public function testGetClientCodeAnalysis(array $data, $expect_exception = null)
	{
		$service = $this->getInstance();
		if ($expect_exception) {
			$this->expectException($expect_exception);
		}


		$code_severities = $service->getClientCodeAnalysis($data);

		foreach ($code_severities as $index => $code_severity) {
			$this->assertSame($data['code_analysis'][$index]['severity']['name'], $code_severity->getName());
			$this->assertSame($data['code_analysis'][$index]['severity']['discrepancy_count'], $code_severity->getDiscrepancyCount());
			foreach ($code_severity->getDiscrepancies() as $index2 => $discrepancy) {
				$this->assertSame($data['code_analysis'][$index]['severity']['discrepancies'][$index2]['property'], $discrepancy->getProperty());
				$this->assertSame($data['code_analysis'][$index]['severity']['discrepancies'][$index2]['message'], $discrepancy->getMessage());
				$this->assertSame($data['code_analysis'][$index]['severity']['discrepancies'][$index2]['lines'], $discrepancy->getLines());
			}

		}

	}

	public function provideTestGetClientCodeAnalysis()
	{
		return [
			[
				[
					'discrepancies'     => [
						[
							'property' => 'test',
							'message'  => 'testik',
							'lines'    => [1, 3, 4]
						]
					],
					'name'              => 'nejmik',
					'discrepancy_count' => 40
				],
				InvalidApiResponseData::class
			],
			[
				[
					'code_analysis' => [
						[
							'severity' => [
								'discrepancies'     => [
									[
										'property' => 'test',
										'message'  => 'testik',
										'lines'    => [1, 3, 4]
									]
								],
								'name'              => 'nejmik',
								'discrepancy_count' => 40
							]
						]
					]
				]
			],
			[
				[
					'code_analysis' => [
						[
							'severity' => [
								'discrepancies' => [
									[
										'property' => 'test',
										'message'  => 'testik',
										'lines'    => [1, 3, 4]
									]
								],

								'discrepancy_count' => 40
							]
						]
					]
				],
				InvalidApiResponseData::class
			],
		];
	}

	/**
	 * @param array $data
	 * @param null $expect_exception
	 * @dataProvider provideTestGetLinkValidation
	 */
	public function testGetLinkValidation(array $data, $expect_exception = null)
	{

		$service = $this->getInstance();
		if ($expect_exception) {
			$this->expectException($expect_exception);
		}

		$link_validaton = $service->getLinkValidation($data);

		if (isset($data['links'])) {
			$links = $link_validaton->getLinks();
			foreach ($data['links'] as $index => $link) {
				$this->assertSame($link['url'], $links[$index]->getUrl());
				$this->assertSame($link['type'], $links[$index]->getType());
				$this->assertSame($link['redirects'], $links[$index]->getRedirects());
				$this->assertSame($link['status'], $links[$index]->getStatus());
				$this->assertSame($link['mime'], $links[$index]->getMime());
				$this->assertSame($link['warning'], $links[$index]->isWarning());
				$this->assertSame($link['alt'], $links[$index]->haveAlt());
				$this->assertSame($link['error'], $links[$index]->getError());
			}
		} else {
			$this->assertEmpty($link_validaton->getLinks());
		}
		if (isset($data['uribl'])) {
			$this->assertSame($data['uribl'], $link_validaton->getUribl());
		} else {
			$this->assertEmpty($link_validaton->getUribl());
		}
	}

	public function provideTestGetLinkValidation()
	{
		return [
			[
				[],
				InvalidApiResponseData::class
			],
			[
				[
					'links' => [[]]
				],
				InvalidApiResponseData::class
			],
			[
				['links'   => [
					[
						'url'       => 'url',
						'type'      => 'link',
						'redirects' => [],
						'status'    => 500,
						'mime'      => 'text/html',
						'warning'   => false,
						'alt'       => false,
						'error'     => 'Forbidden'
					]
				], 'uribl' => ['dkdkdkd']]
			],
			[
				['uribl' => ['gjgjjgjg']],
				InvalidApiResponseData::class
			]
		];
	}

	/**
	 * @param array $data
	 * @param null $expect_exception
	 * @dataProvider provideTestGetSpamResult
	 */
	public function testGetSpamResult(array $data, $expect_exception = null)
	{
		$service = $this->getInstance();
		if ($expect_exception) {
			$this->expectException($expect_exception);
		}
		$spam_results = $service->getSpamResult($data);
		$this->assertCount(count($data), $spam_results);
		foreach ($spam_results as $index => $spam) {
			$this->assertSame($data[$index]['client'], $spam->getClient());
			$this->assertSame($data[$index]['type'], $spam->getType());
			$this->assertSame($data[$index]['spam'], $spam->getSpam());
			$this->assertSame(json_encode($data[$index]['details']), $spam->getDetails());
		}
	}

	public function provideTestGetSpamResult()
	{
		return [
			[
				[]
			],
			[
				[
					['client' => 'test']
				],
				InvalidApiResponseData::class
			],
			[
				[
					['client' => 'test', 'type' => 'dldld']
				],
				InvalidApiResponseData::class
			],
			[
				[
					['client' => 'test', 'type' => 'dldld', 'spam' => 1]
				],
				InvalidApiResponseData::class
			],
			[
				[
					['client' => 'test', 'type' => 'dldld', 'spam' => 1, 'details' => ['ddd']],
					['client' => 'testff', 'type' => 'ff', 'spam' => -1, 'details' => ['ddd']]
				]
			],
		];
	}

}
