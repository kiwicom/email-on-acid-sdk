<?php

namespace EmailOnAcid\Tests\Tests;

use EmailOnAcid\Exception\InvalidApiResponseData;
use EmailOnAcid\Exception\UnsuccessfulActionException;
use EmailOnAcid\Response\Test;
use EmailOnAcid\Tests\Service;
use PHPUnit\Framework\TestCase;

class ServiceTest extends TestCase
{
	public function testGetTests()
	{
		$service = $this->getInstance();

		$time = new \DateTimeImmutable();

		$tags = [
			'tag1' => 'value'
		];

		$headers = [
			'dead' => 'shot'
		];

		$tests = $service->getTests([
			[
				'id'   => 'test',
				'date' => $time->getTimestamp(),
				'type' => Test::TYPE_SPAM
			],
			[
				'id'      => 'test23',
				'date'    => $time->getTimestamp() + 20000,
				'type'    => Test::TYPE_EMAIL,
				'headers' => $headers,
				'tags'    => $tags
			],
		]);
		/** @var Test $firstTest */
		$firstTest = current($tests);

		$this->assertSame(
			'test',
			$firstTest->getId()
		);

		$this->assertSame(
			$time->getTimestamp(),
			$firstTest->getDate()->getTimestamp()
		);

		$this->assertSame(
			Test::TYPE_SPAM,
			$firstTest->getType()
		);

		$this->assertSame(
			[],
			$firstTest->getTags()
		);

		$this->assertSame(
			[],
			$firstTest->getHeaders()
		);
		/** @var Test $secondTest */
		$secondTest = next($tests);

		$this->assertSame(
			$tags,
			$secondTest->getTags()
		);

		$this->assertSame(
			$headers,
			$secondTest->getHeaders()
		);

	}

	public function testSuccessResponse(){
		$service = $this->getInstance();

		$service->successResponse(['success'=>true]);

		$this->expectException(InvalidApiResponseData::class);

		$service->successResponse([]);

	}

	public function testSuccessResponseUnsuccessful(){

		$service = $this->getInstance();

		$this->expectException(UnsuccessfulActionException::class);

		$service->successResponse(['success'=>false]);
	}

	private function getInstance()
	{
		return new Service();
	}

}
