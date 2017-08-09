<?php


namespace EmailOnAcid\SpamTesting;


use EmailOnAcid\Exception\UnsuccessfulActionException;
use EmailOnAcid\Request\RequestFactory;
use EmailOnAcid\Request\SpamTestRequest;
use EmailOnAcid\Request\TestSearchRequest;
use EmailOnAcid\Response\NewSpamTest;
use EmailOnAcid\Response\ReserveSeedList;
use EmailOnAcid\Response\SpamTestClient;
use EmailOnAcid\Response\SpamTestResult;
use EmailOnAcid\Response\Test;
use EmailOnAcid\Router;
use EmailOnAcid\ServiceFactory;

class Api
{
	/**
	 * @var string
	 */
	private static $action_clients = '/spam/clients';
	/**
	 * @var string
	 */
	private static $action_tests = '/spam/tests[/<test_id>]';

	/**
	 * @var string
	 */
	private static $action_test_seed_list = '/spam/tests/<test_id>/seedlist';
	/**
	 * @var string
	 */
	private static $action_seed_list = '/spam/seedlist';
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
		$this->service = isset($serviceFactory) ? $serviceFactory->createSpamTestingService() : (new ServiceFactory())->createSpamTestingService();
	}

	/**
	 * @param SpamTestRequest $request
	 * @return NewSpamTest
	 * @link https://api.emailonacid.com/docs/latest/spam-testing#create-test
	 */
	public function createSpamTest(SpamTestRequest $request): NewSpamTest
	{
		return $this->service->createSpamTest(
			$this->request_factory->post(
				Router::buildUrl(
					self::$action_tests
				),
				$request->jsonSerialize()
			)
		);
	}

	/**
	 * @param string $test_id
	 * @return void
	 * @throws UnsuccessfulActionException
	 * @link https://api.emailonacid.com/docs/latest/spam-testing#delete-test
	 */
	public function deleteTest(string $test_id)
	{
		$this->service->successResponse(
			$this->request_factory->delete(
				Router::buildUrl(
					self::$action_tests,
					[
						'test_id' => $test_id
					]
				)
			)
		);
	}

	/**
	 * @return SpamTestClient[]
	 * @link https://api.emailonacid.com/docs/latest/spam-testing#get-clients
	 */
	public function getClients(): array
	{
		return $this->service->getClients(
			$this->request_factory->get(
				Router::buildUrl(
					self::$action_clients
				)
			)
		);
	}

	/**
	 * @param TestSearchRequest|null $request
	 * @return Test[]
	 * @link https://api.emailonacid.com/docs/latest/spam-testing#get-tests
	 */
	public function getSpamTests(TestSearchRequest $request = null)
	{
		$data = [];
		if (isset($request)) {
			$data = $request->jsonSerialize();
		}
		return $this->service->getSpamTests(
			$this->request_factory->get(
				Router::buildUrl(
					self::$action_tests
				),
				$data
			)
		);
	}

	/**
	 * @param string $test_id
	 * @return SpamTestResult[]
	 * @link https://api.emailonacid.com/docs/latest/spam-testing#get-results
	 */
	public function getResults(string $test_id): array
	{
		return $this->service->getResults(
			$this->request_factory->get(
				Router::buildUrl(
					self::$action_tests,
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
	 * @link https://api.emailonacid.com/docs/latest/spam-testing#get-seed-list
	 */
	public function getSeedList(string $test_id): array
	{
		return $this->request_factory->get(
			Router::buildUrl(
				self::$action_test_seed_list,
				[
					'test_id' => $test_id
				]
			)
		);
	}

	/**
	 * @return ReserveSeedList
	 * @link https://api.emailonacid.com/docs/latest/spam-testing#reserve-seed-list
	 */
	public function getReserveSeedList(): ReserveSeedList
	{
		return $this->service->getReserveSeedList(
			$this->request_factory->get(
				Router::buildUrl(
					self::$action_seed_list
				)
			)
		);
	}

}