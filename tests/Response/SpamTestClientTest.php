<?php

namespace EmailOnAcid\Response;

use PHPUnit\Framework\TestCase;

class SpamTestClientTest extends TestCase
{

	public function testObject()
	{
		$client = 'sdasd';
		$type = 'asdasd';
		$description = 'skokgoskdo';

		try {
			new SpamTestClient(
				$client,
				$type,
				$description
			);
			$this->fail('Should fail due incompatible type');
		} catch (\Exception $e) {
			$this->assertInstanceOf(\InvalidArgumentException::class, $e);
			$type = SpamTestClient::SPAM_TEST_TYPE_B2C;
		}
		$object = new SpamTestClient(
			$client,
			$type,
			$description
		);

		$this->assertSame($client, $object->getClient());
		$this->assertSame($type, $object->getType());
		$this->assertSame($description, $object->getDescription());

	}

}
