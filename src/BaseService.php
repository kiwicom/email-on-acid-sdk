<?php


namespace EmailOnAcid;


use EmailOnAcid\Exception\UnsuccessfulActionException;
use EmailOnAcid\Response\Test;

abstract class BaseService
{
	/**
	 * @var ValidatorInterface | BaseValidator
	 */
	protected $validator;

	/**
	 * @param array $response
	 * @return Test[]
	 */
	public function getTests(array $response): array
	{
		$tests = [];
		foreach ($response as $test) {
			$this->validator->validateGetTests($test);
			$tests[] = new Test(
				$test['id'],
				\DateTimeImmutable::createFromFormat('U', $test['date']),
				$test['type'],
				isset($test['headers']) ? $test['headers'] : [],
				isset($test['tags']) ? $test['tags'] : []
			);
		}
		return $tests;
	}

	/**
	 * @param array $response
	 * @return void
	 * @throws UnsuccessfulActionException
	 */
	public function successResponse(array $response)
	{
		$this->validator->validateSuccessResponse($response);
		if ($response['success'] === false) {
			throw new UnsuccessfulActionException();
		}
	}

}