<?php

namespace EmailOnAcid\Tests\SpamTesting;

use EmailOnAcid\Exception\InvalidApiResponseData;
use EmailOnAcid\SpamTesting\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
	public function testCreateSpamTest()
	{
		$validator = $this->getInstance();
		try {
			$validator->validateCreateSpamTest([]);
			$this->fail('Should fail , missing data');
		} catch (\Exception $e) {
			$this->assertInstanceOf(InvalidApiResponseData::class, $e);
			$this->assertNull(
				$validator->validateCreateSpamTest(['id' => 'tasdasd'])
			);
		}
	}

	public function getInstance()
	{
		return new Validator();
	}

	/**
	 * @param array $response
	 * @param null $expect_exception
	 * @throws \Exception
	 * @dataProvider provideTestGetSpamResult
	 */
	public function testGetSpamResult(array $response, $expect_exception = null)
	{
		if ($expect_exception) {
			$this->expectException($expect_exception);
		}
		$validator = $this->getInstance();
		try {
			$this->assertNull($validator->validateGetSpamResult($response));
		} catch (\Exception $e) {
			$this->assertInstanceOf(InvalidApiResponseData::class, $e);
			throw $e;
		}
	}

	public function provideTestGetSpamResult()
	{
		return [
			[
				['client' => 'tsdf', 'type' => 'fdfsfd', 'spam' => 'gfdgfg', 'details' => 'fdsf'],
			],
			[
				['client' => 'tsdf', 'type' => 'fdfsfd', 'spam' => 'gfdgfg'],
				InvalidApiResponseData::class
			],
			[
				['client' => 'tsdf', 'type' => 'fdfsfd'],
				InvalidApiResponseData::class
			],
			[
				['client' => 'tsdf'],
				InvalidApiResponseData::class
			],
			[
				[],
				InvalidApiResponseData::class
			]
		];

	}

	/**
	 * @param array $response
	 * @param null $expect_exception
	 * @throws \Exception
	 * @dataProvider provideTestGetClients
	 */
	public function testGetClients(array $response, $expect_exception = null)
	{
		$validator = $this->getInstance();
		if ($expect_exception) {
			$this->expectException($expect_exception);
		}
		try {
			$this->assertNull($validator->validateGetClients($response));
		} catch (\Exception $e) {
			$this->assertInstanceOf(InvalidApiResponseData::class, $e);
			throw $e;
		}

	}

	public function provideTestGetClients()
	{
		return [
			[
				['client' => 'sadd', 'type' => 'sadad', 'description' => 'dasdad']
			],
			[
				['client' => 'sadd', 'type' => 'sadad'],
				InvalidApiResponseData::class
			],
			[
				['client' => 'sadd'],
				InvalidApiResponseData::class
			],
			[
				[],
				InvalidApiResponseData::class
			]
		];
	}

	/**
	 * @param array $response
	 * @param null $expect_exception
	 * @throws \Exception
	 * @dataProvider provideTestGetReserveSeedList
	 */
	public function testGetReserveSeedList(array $response, $expect_exception = null)
	{
		$validator = $this->getInstance();
		if ($expect_exception) {
			$this->expectException($expect_exception);
		}
		try {
			$this->assertNull($validator->validateGetReserveSeedList($response));
		} catch (\Exception $e) {
			$this->assertInstanceOf(InvalidApiResponseData::class, $e);
			throw $e;
		}
	}

	public function provideTestGetReserveSeedList()
	{
		return [
			[
				['key' => 'sadd', 'address_list' => []]
			],
			[
				['key' => 'sadd'],
				InvalidApiResponseData::class
			],
			[
				[],
				InvalidApiResponseData::class
			],
		];
	}

}
