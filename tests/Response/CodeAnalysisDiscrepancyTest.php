<?php

namespace EmailOnAcid\Response;

use PHPUnit\Framework\TestCase;

class CodeAnalysisDiscrepancyTest extends TestCase
{
	public function testObject()
	{
		$property = 'asdad';
		$message = 'ggjg';
		$lines = [55, 555, 444];
		$object = new CodeAnalysisDiscrepancy(
			$property,
			$message,
			$lines
		);
		$this->assertSame($property, $object->getProperty());
		$this->assertSame($message, $object->getMessage());
		$this->assertSame($lines, $object->getLines());
	}

}
