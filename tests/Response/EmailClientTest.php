<?php

namespace EmailOnAcid\Tests\Response;

use PHPUnit\Framework\TestCase;

class EmailClientTest extends TestCase
{
	public function testObject()
	{
		$id = 'tasrsa';
		$client = 'tasdsd';
		$os = 'asadasda';
		$category = 'asdadssad';
		$browser = 'asdasdfasf';
		$rotate = true;
		$image_blocking = false;
		$free = false;
		$default = true;


		$email_client = new \EmailOnAcid\Response\EmailClient(
			$id,
			$client,
			$os,
			$category,
			$browser,
			$rotate,
			$image_blocking,
			$free,
			$default
		);

		$this->assertSame($id, $email_client->getId());
		$this->assertSame($client, $email_client->getClient());
		$this->assertSame($os, $email_client->getOs());
		$this->assertSame($category, $email_client->getCategory());
		$this->assertSame($browser, $email_client->getBrowser());
		$this->assertSame($rotate, $email_client->isRotate());
		$this->assertSame($image_blocking, $email_client->isImageBlocking());
		$this->assertSame($free, $email_client->isFree());
		$this->assertSame($default, $email_client->isDefault());


	}

}
