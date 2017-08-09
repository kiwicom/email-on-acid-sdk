<?php

namespace EmailOnAcid\Tests\Request;

use EmailOnAcid\Exception\MissingSmtpInfoException;
use EmailOnAcid\Request\SpamTestRequest;
use EmailOnAcid\Response\SmtpInfo;
use EmailOnAcid\Response\Test;
use PHPUnit\Framework\TestCase;

class SpamTestRequestTest extends TestCase
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
		$test_method = 'testing';
		$from_address = 'asdkaokokd@ifjdijfis';
		$key = 'sdidiad';

		$test = new SpamTestRequest($subject, $html, $url);

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
		$this->assertSame(
			$test_method,
			$test->setTestMethod($test_method)->getTestMethod()
		);
		$this->assertSame(
			$from_address,
			$test->setFromAddress($from_address)->getFromAddress()
		);
		$this->assertSame(
			$key,
			$test->setKey($key)->getKey()
		);

		$smtpInfo = new SmtpInfo('host:url');

		$test->setSmtpInfo($smtpInfo);

		$this->assertSame(
			$smtpInfo,
			$test->getSmtpInfo()
		);
		$test->jsonSerialize();

		$test = new SpamTestRequest($subject, $html, $url);
		$test->setTestMethod(Test::SPAM_TEST_SMTP);

		$this->expectException(MissingSmtpInfoException::class);
		$test->jsonSerialize();

	}

}
