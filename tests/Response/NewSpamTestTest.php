<?php

namespace EmailOnAcid\Response;

use PHPUnit\Framework\TestCase;

class NewSpamTestTest extends TestCase
{
	public function testObject()
	{
		$id = 'asdadad';
		$reference_id = 'asdasd';
		$customer_id = 'asdasdasd';
		$addresses = [
			'asdadsasd'
		];

		$object = new NewSpamTest(
			$id,
			$reference_id,
			$customer_id,
			$addresses
		);

		$this->assertSame($id, $object->getId());
		$this->assertSame($reference_id, $object->getReferenceId());
		$this->assertSame($customer_id, $object->getCustomerId());
		$this->assertSame($addresses, $object->getAddresses());

	}

}
