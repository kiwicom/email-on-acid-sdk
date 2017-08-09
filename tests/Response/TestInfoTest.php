<?php

namespace EmailOnAcid\Response;

use PHPUnit\Framework\TestCase;

class TestInfoTest extends TestCase
{
	public function testObject()
	{

		$subject = 'subjeeekt';
		$date = new \DateTimeImmutable();
		$completed = [];
		$processing = [];
		$bounced = [];

		$object = new TestInfo(
			$subject,
			$date,
			$completed,
			$processing,
			$bounced
		);

		$this->assertSame($subject, $object->getSubject());
		$this->assertSame($date, $object->getDate());
		$this->assertSame($completed, $object->getCompleted());
		$this->assertSame($processing, $object->getProcessing());
		$this->assertSame($bounced, $object->getBounced());
	}

}
