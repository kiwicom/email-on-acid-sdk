<?php


namespace EmailOnAcid\SpamTesting;


use EmailOnAcid\BaseValidator;
use EmailOnAcid\Exception\InvalidApiResponseData;

class Validator extends BaseValidator
{
	/**
	 * @param array $response
	 * @throws InvalidApiResponseData
	 */
	public function validateCreateSpamTest(array $response)
	{
		$this->validateArrayData($response, ['id']);
	}


	/**
	 * @param array $response
	 */
	public function validateGetSpamResult(array $response)
	{
		$this->validateArrayData($response, ['client', 'type', 'spam', 'details']);
	}

	/**
	 * @param array $response
	 */
	public function validateGetClients(array $response)
	{
		$this->validateArrayData($response, ['client', 'type', 'description']);
	}

	/**
	 * @param array $response
	 */
	public function validateGetReserveSeedList(array $response)
	{
		$this->validateArrayData($response, ['key', 'address_list']);
	}

}