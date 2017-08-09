<?php

namespace EmailOnAcid\Response;

use PHPUnit\Framework\TestCase;

class EmailClientTestResultTest extends TestCase
{
	public function testObject()
	{
		$client_id = 'asdasda';
		$display_name = 'asdadasd';
		$client = 'asdasdasd';
		$os = 'asdasdasd';
		$category = 'aigijgijf';
		$status_detail = new TestStatusDetail(
			new \DateTimeImmutable()
		);
		$browser = 'asdasdasdg';
		$screenshots = [
			new ScreenShotResult('asdasd', 'asdasda')
		];
		$thumbnail = 'asdasdasd';
		$status = EmailClientTestResult::STATUS_COMPLETED;

		$object = new EmailClientTestResult(
			$client_id,
			$display_name,
			$client,
			$os,
			$category,
			$status_detail,
			$browser,
			$screenshots,
			$thumbnail,
			$status
		);
		$this->assertSame($client_id, $object->getId());
		$this->assertSame($display_name, $object->getDisplayName());
		$this->assertSame($client, $object->getClient());
		$this->assertSame($status, $object->getStatus());
		$this->assertSame($os, $object->getOs());
		$this->assertSame($category, $object->getCategory());
		$this->assertSame($status_detail, $object->getStatusDetail());
		$this->assertSame($browser, $object->getBrowser());
		$this->assertSame($screenshots, $object->getScreenshots());
		$this->assertSame($thumbnail, $object->getThumbnail());
	}

}
