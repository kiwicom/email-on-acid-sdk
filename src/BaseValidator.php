<?php


namespace EmailOnAcid;


use EmailOnAcid\Exception\InvalidApiResponseData;

abstract class BaseValidator implements ValidatorInterface
{

	/**
	 * @param array $response
	 */
	public function validateSuccessResponse(array $response)
	{
		$this->validateArrayData($response, ['success']);
	}


	/**
	 * @param array $testData
	 * @param array $required
	 * @throws InvalidApiResponseData
	 */
	protected function validateArrayData(array $testData, array $required)
	{
		foreach ($required as $key) {
			if (!array_key_exists($key,$testData)) {
				throw new InvalidApiResponseData(
					sprintf(
						'Api response did not provided required data , "%s" is missing',
						$key
					)
				);
			}
		}
	}

	/**
	 * @param array $testData
	 * @throws InvalidApiResponseData
	 */
	public function validateGetTests(array $testData)
	{
		$this->validateArrayData($testData, ['id', 'date', 'type']);
	}

}