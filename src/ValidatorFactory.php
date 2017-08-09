<?php


namespace EmailOnAcid;


use EmailOnAcid\Tests\Validator;

class ValidatorFactory
{

	/**
	 * @return Validator
	 */
	public function createTestsValidator(): Validator
	{
		return new Validator();
	}

	/**
	 * @return EmailTesting\Validator
	 */
	public function createEmailTestingValidator(): \EmailOnAcid\EmailTesting\Validator
	{
		return new \EmailOnAcid\EmailTesting\Validator();
	}

	/**
	 * @return SpamTesting\Validator
	 */
	public function createSpamTestingValidator(): \EmailOnAcid\SpamTesting\Validator
	{
		return new \EmailOnAcid\SpamTesting\Validator();
	}

	/**
	 * @return EmailClients\Validator
	 */
	public function createEmailClientsValidator(): \EmailOnAcid\EmailClients\Validator
	{
		return new \EmailOnAcid\EmailClients\Validator();
	}

}