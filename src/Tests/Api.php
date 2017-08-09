<?php

namespace EmailOnAcid\Tests;


use EmailOnAcid\Request\RequestFactory;
use EmailOnAcid\Request\TestSearchRequest;
use EmailOnAcid\Response\Test;
use EmailOnAcid\Router;
use EmailOnAcid\ServiceFactory;

class Api
{
	private static $action = 'tests';


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
		$this->service = isset($serviceFactory) ? $serviceFactory->createTestsService() : (new ServiceFactory())->createTestsService();
	}

	/**
	 * @param TestSearchRequest|NULL $search
	 * @return Test[]
	 * @link https://api.emailonacid.com/docs/latest/test-search#get-tests
	 */
	public function getTests(TestSearchRequest $search = NULL): array
	{
		$data = [];
		if ($search) {
			$data = $search->jsonSerialize();
		}
		return $this->service->getTests(
			$this->request_factory->get(
				Router::buildUrl(
					self::$action),
				$data)
		);
	}

}