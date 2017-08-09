<?php

namespace EmailOnAcid\Tests\Response;

use PHPUnit\Framework\TestCase;

class SmtpInfoTest extends TestCase
{

	public function testObject()
	{

		$host = 'test';
		$port = 22;
		$secure = 'for sure';
		$username = 'me';
		$password = 'hard paaaasssword';

		$smtp_info = new \EmailOnAcid\Response\SmtpInfo(
			$host,
			$port,
			$secure,
			$username,
			$password
		);

		$this->assertSame($host, $smtp_info->getHost());
		$this->assertSame($port, $smtp_info->getPort());
		$this->assertSame($secure, $smtp_info->getSecure());
		$this->assertSame($username, $smtp_info->getUsername());
		$this->assertSame($password, $smtp_info->getPassword());

		$this->assertSame(
			[
				'host'     => $host,
				'port'     => $port,
				'secure'   => $secure,
				'username' => $username,
				'password' => $password
			],
			$smtp_info->jsonSerialize()
		);

	}

}
