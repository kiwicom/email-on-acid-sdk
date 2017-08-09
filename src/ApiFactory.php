<?php


namespace EmailOnAcid;


use EmailOnAcid\EmailClients\Api as EmailClientsApi;
use EmailOnAcid\EmailTesting\Api as EmailTestingApi;
use EmailOnAcid\Request\RequestFactory;
use EmailOnAcid\SpamTesting\Api as SpamTestingApi;
use EmailOnAcid\Tests\Api as TestApi;
use GuzzleHttp\Client;

/**
 * Class ApiFactory
 * @package EmailOnAcid
 */
class ApiFactory
{

	/**
	 * @var Authentication
	 */
	private $authentication;
	/**
	 * @var RequestFactory
	 */
	private $request_factory;

	/**
	 * @var ServiceFactory|null
	 */
	private $service_factory;

	/**
	 * Api constructor.
	 * @param string $api_key
	 * @param string $password
	 * @param int $request_timeout
	 * @param ServiceFactory|null $service_factory
	 * @param RequestFactory|null $requestFactory
	 */
	public function __construct(string $api_key, string $password, int $request_timeout = 10, ServiceFactory $service_factory = null, RequestFactory $requestFactory = null)
	{
		$this->authentication = new Authentication($api_key, $password);
		$this->request_factory = ($requestFactory) ? $requestFactory : new RequestFactory(new Client(), $this->authentication, $request_timeout);
		$this->service_factory = $service_factory;
	}

	/**
	 * @return EmailClients\Api
	 */
	public function createEmailClientsApi(): EmailClientsApi
	{
		return new EmailClientsApi($this->request_factory, $this->service_factory);
	}

	/**
	 * @return EmailTesting\Api
	 */
	public function createEmailTestingApi(): EmailTestingApi
	{
		return new EmailTestingApi($this->request_factory, $this->service_factory);
	}

	/**
	 * @return SpamTesting\Api
	 */
	public function createSpamTestingApi(): SpamTestingApi
	{
		return new SpamTestingApi($this->request_factory, $this->service_factory);
	}

	/**
	 * @return Tests\Api
	 */
	public function createTestsApi(): TestApi
	{
		return new TestApi($this->request_factory, $this->service_factory);
	}

}