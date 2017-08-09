<?php

namespace EmailOnAcid\Response;

use PHPUnit\Framework\TestCase;

class SpamTestResultTest extends TestCase
{
	public function testObject()
	{

		$client = 'asdasd';
		$type = 'asdasd';
		$spam = 123;
		$details = ['sadasdad'];

		$object = new SpamTestResult(
			$client,
			$type,
			$spam,
			$details
		);

		$this->assertSame($client, $object->getClient());
		$this->assertSame($type, $object->getType());
		$this->assertSame($spam, $object->getSpam());
		$this->assertSame(json_encode($details), $object->getDetails());

		new SpamTestResult($client,$type,$spam,'test');

		$this->expectException(\InvalidArgumentException::class);

		new SpamTestResult($client,$type,$spam,new \stdClass());
	}

}
