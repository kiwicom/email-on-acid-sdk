<?php

namespace EmailOnAcid\Tests;

use EmailOnAcid\Authentication;
use PHPUnit\Framework\TestCase;

class AuthenticationTest extends TestCase
{


	public function testObject()
	{
		$api_key = 'test';
		$password = 'ola';
		$auth = new Authentication($api_key, $password);

		$this->assertSame($api_key, $auth->getApiKey());
		$this->assertSame($password, $auth->getPassword());

	}

}
