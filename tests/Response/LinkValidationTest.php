<?php

namespace EmailOnAcid\Response;

use PHPUnit\Framework\TestCase;

class LinkValidationTest extends TestCase
{

	public function testObject()
	{

		$links = ['asdasda'];
		$uribl = ['jjgjg'];

		$object = new LinkValidation(
			$links,
			$uribl
		);

		$this->assertSame($links, $object->getLinks());
		$this->assertSame($uribl, $object->getUribl());

	}

}
