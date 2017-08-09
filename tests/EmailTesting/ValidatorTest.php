<?php


namespace EmailOnAcid\Tests\EmailTesting;


use EmailOnAcid\EmailTesting\Validator;
use EmailOnAcid\Exception\InvalidApiResponseData;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{

	public function testCreateEmailTest()
	{
		$validator = $this->getInstance();

		try {
			$this->assertNull(
				$validator->validateCreateEmailTest(['id' => 'test'])
			);
		} catch (InvalidApiResponseData $exception) {
			$this->fail($exception->getMessage());
		}

		try {
			$validator->validateCreateEmailTest([]);
			$this->fail('Not enough data provided , should fail');
		} catch (InvalidApiResponseData $exception) {

		}
	}

	private function getInstance()
	{
		return new Validator();
	}

	public function testGetEmailTestInfo()
	{
		$service = $this->getInstance();

		try {
			$service->validateGetEmailTestInfo(['subject' => 'test']);
			$this->fail('Should fail , missing date index');
		} catch (InvalidApiResponseData $exception) {
			try {
				$service->validateGetEmailTestInfo(['date' => 'test']);
				$this->fail('Should fail , missing date index');
			} catch (InvalidApiResponseData $exception) {
				$this->assertNull(
					$service->validateGetEmailTestInfo(['date' => 1231244, 'subject' => 'tsrsr'])
				);
			}
		}
	}

	/**
	 * @param array $data
	 * @param null $expect_exception
	 * @dataProvider provideTestGetResults
	 */
	public function testGetResults(array $data, $expect_exception = null)
	{
		$service = $this->getInstance();
		if ($expect_exception) {
			$this->expectException($expect_exception);
		}
		$this->assertNull(
			$service->validateGetResults($data)
		);
	}

	public function provideTestGetResults()
	{
		return [
			[
				[],
				InvalidApiResponseData::class
			],
			[
				['id' => 'fsd'],
				InvalidApiResponseData::class
			],
			[
				['id' => 'fsd', 'display_name' => 'tasdasd'],
				InvalidApiResponseData::class
			],
			[
				['id' => 'fsd', 'display_name' => 'tasdasd', 'client' => 'asdasd'],
				InvalidApiResponseData::class
			],
			[
				['id' => 'fsd', 'display_name' => 'tasdasd', 'client' => 'asdasd', 'os' => 'asdadsa'],
				InvalidApiResponseData::class
			],
			[
				['id' => 'fsd', 'display_name' => 'tasdasd', 'client' => 'asdasd', 'os' => 'asdadsa', 'category' => 'asdadsda'],
				InvalidApiResponseData::class
			],
			[
				['id' => 'fsd', 'display_name' => 'tasdasd', 'client' => 'asdasd', 'os' => 'asdadsa', 'category' => 'asdadsda', 'screenshots' => 'dasd'],
				InvalidApiResponseData::class
			],
			[
				['id' => 'fsd', 'display_name' => 'tasdasd', 'client' => 'asdasd', 'os' => 'asdadsa', 'category' => 'asdadsda', 'screenshots' => 'dasd', 'status' => 'sadad'],
				InvalidApiResponseData::class
			],
			[
				['id' => 'fsd', 'display_name' => 'tasdasd', 'client' => 'asdasd', 'os' => 'asdadsa', 'category' => 'asdadsda', 'screenshots' => 'dasd', 'status' => 'sadad', 'status_details' => []],
				InvalidApiResponseData::class
			],
			[
				['id' => 'fsd', 'display_name' => 'tasdasd', 'client' => 'asdasd', 'os' => 'asdadsa', 'category' => 'asdadsda', 'screenshots' => 'dasd', 'status' => 'sadad', 'status_details' => ['submitted' => 53]]
			],
		];
	}

	/**
	 * @param array $response
	 * @param null $expect_exception
	 * @dataProvider provideTestCreateReprocessScreenshots
	 */
	public function testCreateReprocessScreenshots(array $response, $expect_exception = null)
	{
		$validator = $this->getInstance();
		if (isset($expect_exception)) {
			$this->expectException($expect_exception);
		}
		$this->assertNull(
			$validator->validateCreateReprocessScreenshots($response)
		);


	}

	public function provideTestCreateReprocessScreenshots()
	{
		return [
			[
				[],
				InvalidApiResponseData::class
			],
			[
				['success' => true],
				InvalidApiResponseData::class
			],
			[
				['success' => true, 'remaining_reprocesses' => 1],
				InvalidApiResponseData::class
			],
			[
				['success' => true, 'remaining_reprocesses' => 1, 'regional' => false]
			],
		];
	}

	public function testGetTestContent()
	{
		$validator = $this->getInstance();

		try {
			$validator->validateGetTestContent([]);
			$this->fail('Should fail , not enough data provided');
		} catch (\Exception $e) {
			$this->assertInstanceOf(InvalidApiResponseData::class, $e);

			$this->assertNull(
				$validator->validateGetTestContent(['content' => 'htmlsdasdpalspdlas'])
			);

		}
	}

	/**
	 * @param array $response
	 * @param null $expect_exception
	 * @throws \Exception
	 * @dataProvider provideTestGetClientCodeAnalysis
	 */
	public function testGetClientCodeAnalysis(array $response, $expect_exception = null)
	{
		$validator = $this->getInstance();
		if ($expect_exception) {
			$this->expectException($expect_exception);
		}
		try {
			$this->assertNull(
				$validator->validateGetClientCodeAnalysis($response)
			);
		} catch (\Exception $e) {
			$this->assertInstanceOf(InvalidApiResponseData::class, $e);
			throw $e;
		}
	}

	public function provideTestGetClientCodeAnalysis()
	{
		return [
			[
				[],
				InvalidApiResponseData::class
			],
			[
				['name' => 'nameeez'],
				InvalidApiResponseData::class
			],
			[
				['name' => 'nameeez', 'discrepancy_count' => 12412],
				InvalidApiResponseData::class
			],
			[
				['name' => 'nameeez', 'discrepancy_count' => 12412, 'discrepancies' => []]
			],
		];
	}

	/**
	 * @param array $response
	 * @param null $expect_exception
	 * @throws \Exception
	 * @dataProvider provideTestGetLinkValidation
	 */
	public function testGetLinkValidation(array $response, $expect_exception = null)
	{
		$validator = $this->getInstance();
		if ($expect_exception) {
			$this->expectException($expect_exception);
		}
		try {
			$this->assertNull(
				$validator->validateGetLinkValidation($response)
			);
		} catch (\Exception $e) {
			$this->assertInstanceOf(InvalidApiResponseData::class, $e);
			throw $e;
		}
	}

	public function provideTestGetLinkValidation()
	{
		return [
			[
				[],
				InvalidApiResponseData::class
			],
			[
				['links' => []],
				InvalidApiResponseData::class
			],
			[
				['links' => [], 'uribl' => []]
			]
		];
	}

	/**
	 * @param array $data
	 * @param null $expect_exception
	 * @dataProvider provideTestGetSpamResult
	 */
	public function testGetSpamResult(array $data, $expect_exception = null)
	{
		$validator = $this->getInstance();
		if ($expect_exception) {
			$this->expectException($expect_exception);
		}
		$this->assertNull($validator->validateGetSpamResult($data));


	}

	public function provideTestGetSpamResult()
	{
		return [
			[
				[],
				InvalidApiResponseData::class
			],
			[
				['client' => 'test'],
				InvalidApiResponseData::class
			],
			[
				['client' => 'test', 'type' => 'dldld'],
				InvalidApiResponseData::class
			],
			[
				['client' => 'test', 'type' => 'dldld', 'spam' => 1],
				InvalidApiResponseData::class
			],
			[
				['client' => 'test', 'type' => 'dldld', 'spam' => 1, 'details' => 'ddd']
			],
		];
	}
}