<?php

namespace EmailOnAcid\EmailClients;


use EmailOnAcid\BaseService;
use EmailOnAcid\Exception\InvalidApiResponseData;
use EmailOnAcid\Response\EmailClient;
use EmailOnAcid\Response\EmailClientTip;
use EmailOnAcid\Response\NewDefaultClients;
use EmailOnAcid\ValidatorFactory;

class Service extends BaseService
{
	/**
	 * @var Validator
	 */
	protected $validator;


	public function __construct(ValidatorFactory $validatorFactory = null)
	{
		$this->validator = isset($validatorFactory) ? $validatorFactory->createEmailClientsValidator() : (new ValidatorFactory())->createEmailClientsValidator();
	}


	/**
	 * @param array $response
	 * @return EmailClient[]
	 * @throws InvalidApiResponseData
	 */
	public function getClients(array $response): array
	{
		$clients = [];
		if (!isset($response['clients'])) {
			throw new InvalidApiResponseData('Invalid response for email clients data , missing clients index');
		}
		foreach ($response['clients'] as $client_data) {
			$this->validator->validateGetClients($client_data);
			$clients[] = new EmailClient(
				$client_data['id'],
				$client_data['client'],
				$client_data['os'],
				$client_data['category'],
				isset($client_data['browser']) ? $client_data['browser'] : '',
				isset($client_data['rotate']) ? $client_data['rotate'] : '',
				isset($client_data['image_blocking']) ? $client_data['image_blocking'] : '',
				isset($client_data['free']) ? $client_data['free'] : '',
				isset($client_data['default']) ? $client_data['default'] : ''

			);
		}
		return $clients;
	}

	/**
	 * @param array $response
	 * @return EmailClientTip[]
	 * @throws InvalidApiResponseData
	 */
	public function getClientTips(array $response): array
	{
		$tips = [];

		if (!array_key_exists('client',$response)) {
			throw new InvalidApiResponseData('Invalid response for email client data , missing client index');
		}
		if (!array_key_exists('tips',$response)) {
			throw new InvalidApiResponseData('Invalid response for email tips data , missing client index');
		}
		$client = $response['client'];
		foreach ($response['tips'] as $tipData) {
			$this->validator->validateGetClientTips($tipData);
			$tips[] = new EmailClientTip($client, $tipData['name'], $tipData['tip']);
		}
		return $tips;
	}

	/**
	 * @param array $response
	 * @return NewDefaultClients
	 */
	public function setDefaultClients(array $response): NewDefaultClients
	{
		$clients = isset($response['clients']) ? $response['clients'] : [];
		$warnings = isset($response['warnings']) ? $response['warnings'] : [];
		return new NewDefaultClients(
			$clients,
			$warnings
		);
	}

}