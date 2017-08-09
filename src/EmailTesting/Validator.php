<?php


namespace EmailOnAcid\EmailTesting;


use EmailOnAcid\BaseValidator;

class Validator extends BaseValidator
{
	/**
	 * @param array $response
	 */
	public function validateCreateEmailTest(array $response)
	{
		$this->validateArrayData($response, ['id']);
		if (isset($response['spam'])) {
			$this->validateArrayData($response['spam'], ['key', 'address_list']);
		}
	}


	/**
	 * @param array $response
	 */
	public function validateGetEmailTestInfo(array $response)
	{
		$this->validateArrayData($response, ['subject', 'date']);
	}

	/**
	 * @param array $response
	 */
	public function validateGetResults(array $response)
	{
		$this->validateArrayData($response, ['id', 'display_name', 'client', 'os', 'category', 'screenshots', 'status', 'status_details']);
		$this->validateArrayData($response['status_details'], ['submitted']);
	}

	/**
	 * @param array $response
	 */
	public function validateCreateReprocessScreenshots(array $response)
	{
		$this->validateArrayData($response, ['success', 'remaining_reprocesses', 'regional']);
	}


	/**
	 * @param array $response
	 */
	public function validateGetTestContent(array $response)
	{
		$this->validateArrayData($response, ['content']);
	}


	/**
	 * @param array $response
	 */
	public function validateGetClientCodeAnalysis(array $response)
	{
		$this->validateArrayData($response, ['name', 'discrepancy_count', 'discrepancies']);
	}


	/**
	 * @param array $response
	 */
	public function validateGetLinkValidation(array $response)
	{
		$this->validateArrayData($response, ['links', 'uribl']);
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
	public function validateGetLinkValidationLink(array $response)
	{
		$this->validateArrayData($response, ['url', 'type', 'redirects', 'status', 'mime', 'warning', 'alt', 'error']);
	}

}