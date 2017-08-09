<?php


namespace EmailOnAcid\Tests\EmailClients;


use EmailOnAcid\EmailClients\Validator;
use EmailOnAcid\Exception\InvalidApiResponseData;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
	public function testGetClients()
	{
		$validator = $this->getInstance();
		try {
			$validator->validateGetClients([
				'id' => 'asdasd',
				'os' => 'sadaf'
			]);
			$this->fail('Should fail due incomplete data');
		} catch (InvalidApiResponseData $exception) {
			$id = 'asdasd';
			$os = 'sadaf';
			$category = 'sdasda';
			$client = 'asdad';
			$this->assertNull(
				$validator->validateGetClients([
					'id'       => $id,
					'os'       => $os,
					'category' => $category,
					'client'   => $client
				])
			);

		}
	}

	private function getInstance(): Validator
	{
		return new Validator();
	}

}