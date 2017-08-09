<?php

namespace EmailOnAcid\Tests\Tests;

use EmailOnAcid\Exception\TestTypeException;
use EmailOnAcid\Response\Test;
use PHPUnit\Framework\TestCase;

class TestTest extends TestCase
{

	public function testObject()
	{

		$id = 'test123';
		$date = new \DateTimeImmutable();
		$type = Test::TYPE_SPAM;
		$headers = ['test' => 'head'];
		$tags = ['tag' => 'ne'];

		$test = new Test($id, $date, $type, $headers, $tags);

		$this->assertSame(
			$id,
			$test->getId()
		);
		$this->assertSame(
			$date,
			$test->getDate()
		);
		$this->assertSame(
			$type,
			$test->getType()
		);
		$this->assertSame(
			$headers,
			$test->getHeaders()
		);
		$this->assertSame(
			$tags,
			$test->getTags()
		);

		try {
			$test = new Test($id, $date, 'type random', [], []);
			$this->assertSame(
				$type,
				$test->getType()
			);
		} catch (TestTypeException $exception) {

		}

	}

}
