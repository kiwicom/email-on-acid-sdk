<?php


namespace EmailOnAcid\Tests;


use EmailOnAcid\Request\RequestFactory;
use EmailOnAcid\ServiceFactory;
use PHPUnit\Framework\MockObject\MockBuilder;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

trait ApiHelper
{
	/**
	 * @param string $expects
	 * @param array $return
	 * @return RequestFactory|MockObject
	 */
	private function mockRequestFactory(string $expects, $return = []): RequestFactory
	{
		$methods = ['get', 'put', 'post', 'delete'];
		/** @var TestCase $this */
		$mock = $this->getMockBuilder(RequestFactory::class)
			->disableOriginalConstructor()
			->onlyMethods($methods)->getMock();
		foreach ($methods as $method) {
			if ($method !== $expects) {
				$mock->method($method)->willReturn($return);
			} else {
				$mock->expects($this->once())->method($expects)->willReturn($return);
			}
		}


		return $mock;
	}

	/**
	 * @param null|string $method
	 * @param null|string $class
	 * @param mixed $return
	 * @return ServiceFactory|MockObject
	 * @internal param array $methods
	 */
	private function mockServiceFactory(?string $method, ?string $class = null, $return = null): ServiceFactory
	{
		/** @var TestCase $this */
		$mockBuilder = $this->getMockBuilder(ServiceFactory::class)
			->disableOriginalConstructor();
		$mockBuilder->onlyMethods(['createEmailTestingService', 'createTestsService', 'createEmailClientsService', 'createSpamTestingService']);
		$mock = $mockBuilder->getMock();

		$spamTestingMock = $this->getMockBuilder(\EmailOnAcid\SpamTesting\Service::class)
			->disableOriginalConstructor();

		$emailClientsMock = $this->getMockBuilder(\EmailOnAcid\EmailClients\Service::class)
			->disableOriginalConstructor();

		$testMock = $this->getMockBuilder(Service::class)
			->disableOriginalConstructor();

		$emailTestingMock = $this->getMockBuilder(\EmailOnAcid\EmailTesting\Service::class)
			->disableOriginalConstructor();
		if ($method) {
			switch ($class) {
				case Service::class:
					$testMock->onlyMethods([$method]);
					$mockExpect = $testMock = $testMock->getMock();
					break;
				case \EmailOnAcid\SpamTesting\Service::class:
					$spamTestingMock->onlyMethods([$method]);
					$mockExpect = $spamTestingMock = $spamTestingMock->getMock();
					break;
				case \EmailOnAcid\EmailClients\Service::class:
					$emailClientsMock->onlyMethods([$method]);
					$mockExpect = $emailClientsMock = $emailClientsMock->getMock();
					break;
				case \EmailOnAcid\EmailTesting\Service::class:
					$emailTestingMock->onlyMethods([$method]);
					$mockExpect = $emailTestingMock = $emailTestingMock->getMock();
					break;
			}
			if ($return instanceof \Exception) {
				$mockExpect->expects($this->once())->method($method)->willThrowException($return);
			} else {
				$mockExpect->expects($this->once())->method($method)->willReturn($return);
			}
		} else {
			$testMock = $testMock->getMock();
			$spamTestingMock = $spamTestingMock->getMock();
			$emailClientsMock = $emailClientsMock->getMock();
			$emailTestingMock = $emailTestingMock->getMock();
		}


		$mock->method('createEmailTestingService')
			->willReturn(
				$emailTestingMock instanceof MockBuilder ? $emailTestingMock->getMock() : $emailTestingMock
			);
		$mock->method('createTestsService')
			->willReturn(
                $testMock instanceof MockBuilder ? $testMock->getMock() : $testMock
			);
		$mock->method('createEmailClientsService')
			->willReturn(
                $emailClientsMock instanceof MockBuilder ? $emailClientsMock->getMock() : $emailClientsMock
			);
		$mock->method('createSpamTestingService')
			->willReturn(
                $spamTestingMock instanceof MockBuilder ? $spamTestingMock->getMock() : $spamTestingMock
			);

		return $mock;
	}

	private function mockEmailTestingApi(RequestFactory $request_factory, ServiceFactory $service_factory): \EmailOnAcid\EmailTesting\Api
	{
		return new \EmailOnAcid\EmailTesting\Api($request_factory, $service_factory);
	}

	private function mockEmailClientsApi(RequestFactory $request_factory, ServiceFactory $service_factory): \EmailOnAcid\EmailClients\Api
	{
		return new \EmailOnAcid\EmailClients\Api($request_factory, $service_factory);
	}

	private function mockSpamTestingApi(RequestFactory $request_factory, ServiceFactory $service_factory): \EmailOnAcid\SpamTesting\Api
	{
		return new \EmailOnAcid\SpamTesting\Api($request_factory, $service_factory);
	}

	private function mockTestsApi(RequestFactory $request_factory, ServiceFactory $service_factory): Api
	{
		return new Api($request_factory, $service_factory);
	}

}
