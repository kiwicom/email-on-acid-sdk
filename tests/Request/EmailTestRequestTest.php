<?php

namespace EmailOnAcid\Tests\Request;

use EmailOnAcid\Exception\MissingTestContentException;
use EmailOnAcid\Request\EmailTestRequest;
use EmailOnAcid\Request\SpamTestRequest;
use PHPUnit\Framework\TestCase;

class EmailTestRequestTest extends TestCase
{

	public function testObject()
	{

		$subject = 'Hola hola';
		$html = '<div></div>';
		$url = null;
		$transfer_encoding = 'coded';
		$charset = 'characters';
		$free_test = false;
		$sandbox = true;
		$reference_id = '1239293';
		$customer_id = '231231';
		$clients = ['asdodsisad', 'igigig', 'gigig'];
		$image_blocking = false;

		$test = new EmailTestRequest($subject, $html, $url);

		$this->assertSame(
			$subject,
			$test->getSubject()
		);

		$this->assertSame(
			$html,
			$test->getHtml()
		);

		$this->assertSame(
			$url,
			$test->getUrl()
		);

		$this->assertSame(
			$transfer_encoding,
			$test->setTransferEncoding($transfer_encoding)->getTransferEncoding()
		);
		$this->assertSame(
			$charset,
			$test->setCharset($charset)->getCharset()
		);
		$this->assertSame(
			$free_test,
			$test->setFreeTest($free_test)->isFreeTest()
		);
		$this->assertSame(
			$sandbox,
			$test->setSandbox($sandbox)->isSandbox()
		);
		$this->assertSame(
			$reference_id,
			$test->setReferenceId($reference_id)->getReferenceId()
		);
		$this->assertSame(
			$customer_id,
			$test->setCustomerId($customer_id)->getCustomerId()
		);
		$this->assertSame(
			$clients,
			$test->setClients($clients)->getClients()
		);
		$this->assertSame(
			$image_blocking,
			$test->setImageBlocking($image_blocking)->isImageBlocking()
		);
		$spam = new SpamTestRequest($subject, $html, $url);

		$test->setSpam(
			$spam
		);

		$this->assertSame(
			$spam,
			$test->getSpam()
		);

		$tags = ['tag1', 'tag2'];

		$test->setTags($tags);

		$this->assertSame(
			$tags,
			$test->getTags()
		);

	}

	public function testFailCreation()
	{

		$this->expectException(MissingTestContentException::class);
		new EmailTestRequest('Olala', null);


	}

}
