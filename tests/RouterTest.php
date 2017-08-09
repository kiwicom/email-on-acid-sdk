<?php
/**
 * Created by PhpStorm.
 * User: janbielik
 * Date: 26.06.17
 * Time: 13:35
 */

namespace EmailOnAcid\Tests;

use EmailOnAcid\Exception\RouterException;
use EmailOnAcid\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
	public function testUrl()
	{
		$action = 'tests';

		$this->assertSame(
			Router::getApiEndpoint() . '/tests',
			Router::buildUrl($action)
		);

		$action = 'tests/<test_id>';

		try {
			$this->assertSame(
				Router::getApiEndpoint() . '/tests',
				Router::buildUrl($action)
			);
		} catch (RouterException $exception) {
		}

		$this->assertSame(
			Router::getApiEndpoint() . '/tests/12',
			Router::buildUrl($action, ['test_id' => 12])
		);

		$action = 'tests/<test_id>[/<client_id>]';

		$this->assertSame(
			Router::getApiEndpoint() . '/tests/12',
			Router::buildUrl($action, ['test_id' => 12])
		);
		$this->assertSame(
			Router::getApiEndpoint() . '/tests/12/5',
			Router::buildUrl($action, ['test_id' => 12, 'client_id' => 5])
		);

		$action = 'tests[/<test_id>]';
		$this->assertSame(
			Router::getApiEndpoint() . '/tests',
			Router::buildUrl($action)
		);
		$this->assertSame(
			Router::getApiEndpoint() . '/tests/12',
			Router::buildUrl($action, ['test_id' => 12])
		);

	}

	public function testUrlInvalid()
	{
		$this->expectException(\InvalidArgumentException::class);

		$this->assertSame(
			Router::getApiEndpoint() . '/tests/12',
			Router::buildUrl('action', ['test_id' => (new \stdClass())])
		);
	}

}
