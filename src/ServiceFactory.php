<?php


namespace EmailOnAcid;


use EmailOnAcid\EmailTesting\Service;

class ServiceFactory
{
	/**
	 * @var ValidatorFactory | null
	 */
	private $validator_factory;

	public function __construct(ValidatorFactory $validatorFactory = null)
	{
		$this->validator_factory = $validatorFactory;
	}

	/**
	 * @return Service
	 */
	public function createEmailTestingService(): Service
	{
		return new Service($this->validator_factory);
	}

	/**
	 * @return Tests\Service
	 */
	public function createTestsService(): \EmailOnAcid\Tests\Service
	{
		return new \EmailOnAcid\Tests\Service($this->validator_factory);
	}

	/**
	 * @return EmailClients\Service
	 */
	public function createEmailClientsService(): \EmailOnAcid\EmailClients\Service
	{
		return new \EmailOnAcid\EmailClients\Service($this->validator_factory);
	}

	/**
	 * @return SpamTesting\Service
	 */
	public function createSpamTestingService(): \EmailOnAcid\SpamTesting\Service
	{
		return new \EmailOnAcid\SpamTesting\Service($this->validator_factory);
	}

}