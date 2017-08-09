<?php

namespace EmailOnAcid\Response;

use PHPUnit\Framework\TestCase;

class ReserveSeedListTest extends TestCase
{
	public function testObject()
	{
		$key = 'keyjakblazen';
		$addresses = [
			'sdasd',
			'asdod'
		];

		$object = new ReserveSeedList(
			$key,
			$addresses
		);

		$this->assertSame($key, $object->getKey());
		$this->assertSame($addresses, $object->getAddressList());
	}

}
