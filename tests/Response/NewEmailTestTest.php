<?php

namespace EmailOnAcid\Tests\Response;

use EmailOnAcid\Response\NewEmailTest;
use EmailOnAcid\Response\NewSpamTest;
use PHPUnit\Framework\TestCase;

class NewEmailTestTest extends TestCase
{

	public function testObject()
	{

		$test_id = 'fogiig';
		$reference_id = "123ABC";
		$customer_id = "1";

		$spam_id = "sidiig";
		$addresses = [
			"spam_address1@example.com",
			"spam_address2@example.com"
		];

		$spam = new NewSpamTest(
			$spam_id,
			$reference_id,
			$customer_id,
			$addresses
		);

		$object = new NewEmailTest(
			$test_id,
			$reference_id,
			$customer_id,
			$spam
		);

		$this->assertSame($test_id, $object->getId());
		$this->assertSame($reference_id, $object->getReferenceId());
		$this->assertSame($customer_id, $object->getCustomerId());
		$this->assertSame($spam, $object->getSpam());


	}

}
