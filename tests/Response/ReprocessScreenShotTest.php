<?php

namespace EmailOnAcid\Response;

use PHPUnit\Framework\TestCase;

class ReprocessScreenShotTest extends TestCase
{
	public function testObject()
	{
		$client_id = 'asdisakd';
		$success = false;
		$remaing_reprocesses = 14;
		$regional = false;
		$reason = 'asdadasd';

		$object = new ReprocessScreenShot(
			$client_id,
			$success,
			$remaing_reprocesses,
			$regional,
			$reason
		);

		$this->assertSame($client_id, $object->getClientId());
		$this->assertSame($success, $object->isSuccess());
		$this->assertSame($remaing_reprocesses, $object->getRemainingReprocesses());
		$this->assertSame($regional, $object->isRegional());
		$this->assertSame($reason, $object->getReason());
	}


}
