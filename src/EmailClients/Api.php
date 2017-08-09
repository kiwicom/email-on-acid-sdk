<?php

namespace EmailOnAcid\EmailClients;


use EmailOnAcid\Exception\InvalidApiResponseData;
use EmailOnAcid\Request\RequestFactory;
use EmailOnAcid\Response\EmailClient;
use EmailOnAcid\Response\EmailClientTip;
use EmailOnAcid\Response\NewDefaultClients;
use EmailOnAcid\Router;
use EmailOnAcid\ServiceFactory;

class Api
{
	/**
	 * @var string
	 */
	private static $action_clients = 'email/clients[/<default>]';
	/**
	 * @var string
	 */
	private static $action_tips = 'email/tips/<client_id>';
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
		$this->service = isset($serviceFactory) ? $serviceFactory->createEmailClientsService() : (new ServiceFactory())->createEmailClientsService();
	}

	/**
	 * @return EmailClient[]
	 * @throws InvalidApiResponseData
	 * @link https://api.emailonacid.com/docs/latest/email-clients#get-clients
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
	 * @return string[]
	 * @throws InvalidApiResponseData
	 * @link https://api.emailonacid.com/docs/latest/email-clients#get-default-clients
	 */
	public function getDefaultClients(): array
	{
		$response = $this->request_factory->get(
			Router::buildUrl(
				self::$action_clients,
				['default' => 'default']
			)
		);
		if (!isset($response['clients'])) {
			throw new InvalidApiResponseData('Missing clients index in response');
		}
		return $response['clients'];
	}

	/**
	 * @param string $client_id
	 * @return array|EmailClientTip[]
	 * @link https://api.emailonacid.com/docs/latest/email-clients#get-client-tips
	 */
	public function getClientTips(string $client_id): array
	{
		return $this->service->getClientTips(
			$this->request_factory->get(
				Router::buildUrl(
					self::$action_tips,
					['client_id' => $client_id]
				)
			)
		);
	}

	/**
	 * @param string[] $clients Email client ids
	 * @return NewDefaultClients
	 * @link https://api.emailonacid.com/docs/latest/email-clients#set-default-clients
	 */
	public function setDefaultClients(array $clients): NewDefaultClients
	{
		return $this->service->setDefaultClients(
			$this->request_factory->put(
				Router::buildUrl(
					self::$action_clients,
					['default' => 'default']
				),
				['clients' => $clients]
			)
		);
	}


}