<?php


namespace EmailOnAcid\EmailClients;


use EmailOnAcid\BaseValidator;
use EmailOnAcid\Exception\InvalidApiResponseData;

class Validator extends BaseValidator
{


	/**
	 * @param array $response
	 * @throws InvalidApiResponseData
	 */
	public function validateGetClients(array $response)
	{
		$required = ['id', 'client', 'os', 'category'];
		$this->validateArrayData($response, $required);
	}


	/**
	 * @param array $data
	 */
	public function validateGetClientTips(array $data)
	{
		$this->validateArrayData($data, ['name', 'tip']);
	}

}