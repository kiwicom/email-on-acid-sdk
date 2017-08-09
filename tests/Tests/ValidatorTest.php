<?php


namespace EmailOnAcid\Tests\Tests;


use EmailOnAcid\Exception\InvalidApiResponseData;
use EmailOnAcid\Response\Test;
use EmailOnAcid\Tests\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
	public function testSuccessResponse()
	{
		$validator = $this->getInstance();
		try {
			$validator->validateSuccessResponse([]);
			$this->fail('Should fail due lack of data on input');
		} catch (\Exception $e) {
			$this->assertInstanceOf(InvalidApiResponseData::class, $e);
			$this->assertNull(
				$validator->validateSuccessResponse(['success' => false])
			);
		}
	}

	private function getInstance()
	{
		return new Validator();
	}

	/**
	 * @param array $data
	 * @param null $expect_exception
	 * @throws \Exception
	 * @dataProvider provideTestGetTests
	 */
	public function testGetTests(array $data, $expect_exception = null)
	{
		$validator = $this->getInstance();
		if ($expect_exception) {
			$this->expectException($expect_exception);
		}
		try {
			$this->assertNull(
				$validator->validateGetTests($data)
			);
		} catch (\Exception $e) {
			$this->assertInstanceOf(InvalidApiResponseData::class, $e);
			throw $e;
		}

	}

	public function provideTestGetTests()
	{
		return [
			[
				[],
				InvalidApiResponseData::class
			],
			[
				['id' => 'tdfsdf'],
				InvalidApiResponseData::class
			],
			[
				['id' => 'tdfsdf', 'date' => 12312313],
				InvalidApiResponseData::class
			],
			[
				['id' => 'tdfsdf', 'date' => 12312313, 'type' => Test::TYPE_EMAIL]
			],
		];
	}

	public function testValidateGetTests()
	{
		$validator = $this->getInstance();

		try {
			$validator->validateGetTests([
				'id' => 'test'
			]);
		} catch (InvalidApiResponseData $exception) {
			$this->assertTrue(true);
		}

		try {
			$validator->validateGetTests([
				'id'   => 'test',
				'date' => 123123123,
				'type' => 'type'
			]);
			$this->assertTrue(true);
		} catch (InvalidApiResponseData $exception) {
			$this->fail('Required data are present should pass');
		}
	}

}