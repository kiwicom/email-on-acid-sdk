<?php

namespace EmailOnAcid\Response;

use PHPUnit\Framework\TestCase;

class ScreenShotResultTest extends TestCase
{

	public function testObject()
	{

		$type = 'asdaoskdasd';
		$screen_shot = 'asdaidsiasjdjasjdijaijsd';

		$object = new ScreenShotResult(
			$type,
			$screen_shot
		);

		$this->assertSame($type, $object->getType());
		$this->assertSame($screen_shot, $object->getScreenShot());
	}
}
