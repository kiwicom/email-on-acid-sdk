<?php

namespace EmailOnAcid\Response;

use PHPUnit\Framework\TestCase;

class TestContentTest extends TestCase
{
	public function testObject()
	{

		$content = 'sadijasdjisajdiasd';

		$testContent = new TestContent(
			$content
		);

		$this->assertSame($content, $testContent->getContent());
	}

}
