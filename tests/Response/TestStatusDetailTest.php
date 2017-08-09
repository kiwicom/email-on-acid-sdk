<?php

namespace EmailOnAcid\Response;

use PHPUnit\Framework\TestCase;

class TestStatusDetailTest extends TestCase
{

	public function testObject()
	{
		$submitted = new \DateTimeImmutable();
		$attempts = 123;
		$completed = new \DateTimeImmutable();
		$bounce_code = 's9didiid';
		$bounce_message = 'bounty';


		$object = new TestStatusDetail(
			$submitted,
			$attempts,
			$completed,
			$bounce_code,
			$bounce_message
		);

		$this->assertSame($submitted, $object->getSubmitted());
		$this->assertSame($attempts, $object->getAttempts());
		$this->assertSame($completed, $object->getCompleted());
		$this->assertSame($bounce_code, $object->getBounceCode());
		$this->assertSame($bounce_message, $object->getBounceMessage());

	}

}
