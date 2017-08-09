<?php

namespace EmailOnAcid\EmailTesting;


use EmailOnAcid\Exception\UnsuccessfulActionException;
use EmailOnAcid\Request\EmailTestRequest;
use EmailOnAcid\Request\RequestFactory;
use EmailOnAcid\Request\TestSearchRequest;
use EmailOnAcid\Response\CodeAnalysisSeverity;
use EmailOnAcid\Response\EmailClientTestResult;
use EmailOnAcid\Response\LinkValidation;
use EmailOnAcid\Response\NewEmailTest;
use EmailOnAcid\Response\ReprocessScreenShot;
use EmailOnAcid\Response\SpamTestResult;
use EmailOnAcid\Response\Test;
use EmailOnAcid\Response\TestContent;
use EmailOnAcid\Response\TestInfo;
use EmailOnAcid\Router;
use EmailOnAcid\ServiceFactory;

class Api
{
	const CONTENT_TYPE_INLINE_CSS = 'inlinecss',
		CONTENT_TYPE_TEXT_ONLY = 'textonly';
	/**
	 * @var string
	 */
	private static $action_tests = '/email/tests[/<test_id>]';
	/**
	 * @var string
	 */
	private static $action_result = '/email/tests/<test_id>/results[/<client_id>]';
	/**
	 * @var string
	 */
	private static $action_content = '/email/tests/<test_id>/content[/<type>]';
	/**
	 * @var string
	 */
	private static $action_code_analysis = '/email/tests/<test_id>/codeanalysis/<client_id>';
	/**
	 * @var string
	 */
	private static $action_link_validation = '/email/tests/<test_id>/links';
	/**
	 * @var string
	 */
	private static $action_spam_result = '/email/tests/<test_id>/spam/results';
	/**
	 * @var string
	 */
	private static $action_spam_seed_list = '/email/tests/<test_id>/spam/seedlist';
	/**
	 * @var RequestFactory
	 */
	private $request_factory;

	/**
	 * @var Service
	 */
	private $service;

	/**
	 * Api constructor.
	 * @param RequestFactory $request_factory
	 * @param ServiceFactory|null $serviceFactory
	 */
	public function __construct(RequestFactory $request_factory, ServiceFactory $serviceFactory = null)
	{
		$this->request_factory = $request_factory;
		$this->service = isset($serviceFactory) ? $serviceFactory->createEmailTestingService() : (new ServiceFactory())->createEmailTestingService();
	}

	/**
	 * @param EmailTestRequest $newTest
	 * @return NewEmailTest
	 * @link https://api.emailonacid.com/docs/latest/email-testing#create-test
	 */
	public function createEmailTest(EmailTestRequest $newTest): NewEmailTest
	{
		return $this->service->createEmailTest(
			$this->request_factory->post(
				Router::buildUrl(
					static::$action_tests
				),
				$newTest->jsonSerialize()
			)
		);
	}

	/**
	 * @param string $test_id
	 * @param array $client_ids
	 * @return ReprocessScreenShot[]
	 * @link https://api.emailonacid.com/docs/latest/email-testing#reprocess
	 */
	public function createReprocessScreenshots(string $test_id, array $client_ids): array
	{
		return $this->service->createReprocessScreenshots(
			$this->request_factory->put(
				Router::buildUrl(
					self::$action_result,
					[
						'test_id'   => $test_id,
						'client_id' => 'reprocess'
					]
				),
				[
					'clients' => $client_ids
				]
			)
		);
	}

	/**
	 * @param string $test_id
	 * @return LinkValidation
	 * @link https://api.emailonacid.com/docs/latest/email-testing#link-validation
	 */
	public function createLinkValidation(string $test_id): LinkValidation
	{
		return $this->service->getLinkValidation(
			$this->request_factory->put(
				Router::buildUrl(
					self::$action_link_validation,
					[
						'test_id' => $test_id
					]
				),
				['processing' => 1]
			)
		);
	}

	/**
	 * @param string $test_id
	 * @return void
	 * @throws UnsuccessfulActionException
	 * @link https://api.emailonacid.com/docs/latest/email-testing#delete-test
	 */
	public function deleteTest(string $test_id)
	{
		$this->service->successResponse(
			$this->request_factory->delete(
				Router::buildUrl(
					self::$action_tests,
					['test_id' => $test_id]
				)
			)
		);
	}

	/**
	 * @param TestSearchRequest|null $testSearchRequest
	 * @return Test[]
	 * @link https://api.emailonacid.com/docs/latest/email-testing#get-tests
	 */
	public function getEmailTests(TestSearchRequest $testSearchRequest = null): array
	{
		$data = [];
		if (isset($testSearchRequest)) {
			$data = $testSearchRequest->jsonSerialize();
		}
		return $this->service->getEmailTests(
			$this->request_factory->get(
				Router::buildUrl(self::$action_tests),
				$data
			)
		);
	}

	/**
	 * @param string $test_id
	 * @return TestInfo
	 * @link https://api.emailonacid.com/docs/latest/email-testing#get-test
	 */
	public function getTestInfo(string $test_id): TestInfo
	{
		return $this->service->getEmailTestInfo(
			$this->request_factory->get(
				Router::buildUrl(
					self::$action_tests,
					['test_id' => $test_id]
				)
			)
		);
	}

	/**
	 * @param string $test_id
	 * @param null|string $client_id
	 * @return EmailClientTestResult[]
	 * @link https://api.emailonacid.com/docs/latest/email-testing#get-results
	 */
	public function getResults(string $test_id, ?string $client_id = null): array
	{
		$parameters = [
			'test_id' => $test_id
		];
		if (isset($client_id)) {
			$parameters['client_id'] = $client_id;
		}
		return $this->service->getResults(
			$this->request_factory->get(
				Router::buildUrl(
					self::$action_result,
					$parameters
				)
			)
		);
	}

	/**
	 * @param string $test_id
	 * @param null|string $content_type
	 * @return TestContent
	 * @link https://api.emailonacid.com/docs/latest/email-testing#get-test-content
	 */
	public function getTestContent(string $test_id, ?string $content_type = null): TestContent
	{
		$parameters = [
			'test_id' => $test_id
		];
		if (isset($content_type)) {
			$parameters['type'] = $content_type;
		}
		return $this->service->getTestContent(
			$this->request_factory->get(
				Router::buildUrl(
					self::$action_content,
					$parameters
				)
			)
		);
	}

	/**
	 * @param string $test_id
	 * @param null|string $client_id
	 * @return CodeAnalysisSeverity[]
	 * @link https://api.emailonacid.com/docs/latest/email-testing#code-analysis
	 */
	public function getClientCodeAnalysis(string $test_id, string $client_id): array
	{
		return $this->service->getClientCodeAnalysis(
			$this->request_factory->get(
				Router::buildUrl(
					self::$action_code_analysis,
					[
						'test_id'   => $test_id,
						'client_id' => $client_id
					]
				)
			)
		);
	}

	/**
	 * @param string $test_id
	 * @return LinkValidation
	 * @link https://api.emailonacid.com/docs/latest/email-testing#link-validation
	 */
	public function getLinkValidation(string $test_id): LinkValidation
	{
		return $this->service->getLinkValidation(
			$this->request_factory->get(
				Router::buildUrl(
					self::$action_link_validation,
					[
						'test_id' => $test_id
					]
				)
			)
		);
	}

	/**
	 * @param string $test_id
	 * @return SpamTestResult[]
	 * @link https://api.emailonacid.com/docs/latest/email-testing#spam-results
	 */
	public function getSpamResult(string $test_id): array
	{
		return $this->service->getSpamResult(
			$this->request_factory->get(
				Router::buildUrl(
					self::$action_spam_result,
					[
						'test_id' => $test_id
					]
				)
			)
		);
	}

	/**
	 * @param string $test_id
	 * @return string[]
	 * @link https://api.emailonacid.com/docs/latest/email-testing#spam-seed-list
	 */
	public function getSpamSeedList(string $test_id): array
	{
		return $this->request_factory->get(
			Router::buildUrl(
				self::$action_spam_seed_list,
				[
					'test_id' => $test_id
				]
			)
		);
	}


}