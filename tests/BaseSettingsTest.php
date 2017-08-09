<?php

namespace EmailOnAcid;

use PHPUnit\Framework\TestCase;

class BaseSettingsTest extends TestCase
{

	public function testDateFormat()
	{

		$date = new \DateTimeImmutable();

		$this->assertNotFalse($date->format(BaseSettings::getDateTimeFormat()));

	}

}
