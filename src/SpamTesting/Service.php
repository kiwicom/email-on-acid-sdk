<?php

namespace EmailOnAcid\SpamTesting;

use EmailOnAcid\BaseService;
use EmailOnAcid\Response\NewSpamTest;
use EmailOnAcid\Response\ReserveSeedList;
use EmailOnAcid\Response\SpamTestClient;
use EmailOnAcid\Response\SpamTestResult;
use EmailOnAcid\Response\Test;
use EmailOnAcid\ValidatorFactory;

class Service extends BaseService
{
	/**
	 * @var Validator
	 */
	protected $validator;

	/**
	 * Service constructor.
	 * @param ValidatorFactory|null $validatorFactory
	 */
	public function __construct(ValidatorFactory $validatorFactory = null)
	{
		$this->validator = isset($validatorFactory) ? $validatorFactory->createSpamTestingValidator() : (new ValidatorFactory())->createSpamTestingValidator();
	}


	/**
	 * @param array $response
	 * @return NewSpamTest
	 */
	public function createSpamTest(array $response): NewSpamTest
	{
		$this->validator->validateCreateSpamTest($response);
		return new NewSpamTest(
			$response['id'],
			isset($response['reference_id']) ? $response['reference_id'] : null,
			isset($response['customer_id']) ? $response['customer_id'] : null,
			isset($response['address_list']) ? $response['address_list'] : []
		);
	}

	/**
	 * @param array $response
	 * @return SpamTestResult[]
	 */
	public function getResults(array $response): array
	{
		$result = [];
		foreach ($response as $result_data) {
			$this->validator->validateGetSpamResult($result_data);
			$result[] = new SpamTestResult(
				$result_data['client'],
				$result_data['type'],
				$result_data['spam'],
				$result_data['details']
			);
		}
		return $result;
	}

	/**
	 * @param array $response
	 * @return SpamTestClient[]
	 */
	public function getClients(array $response): array
	{
		$result = [];
		foreach ($response as $client_result) {
			$this->validator->validateGetClients($client_result);
			$result[] = new SpamTestClient(
				$client_result['client'],
				$client_result['type'],
				$client_result['description']
			);
		}
		return $result;
	}

	/**
	 * @param array $response
	 * @return Test[]
	 */
	public function getSpamTests(array $response): array
	{
		return $this->getTests($response);
	}

	/**
	 * @param array $response
	 * @return ReserveSeedList
	 */
	public function getReserveSeedList(array $response): ReserveSeedList
	{
		$this->validator->validateGetReserveSeedList($response);
		return new ReserveSeedList(
			$response['key'],
			$response['address_list']
		);
	}

}