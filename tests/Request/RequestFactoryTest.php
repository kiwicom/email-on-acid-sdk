<?php

namespace EmailOnAcid\Tests\Request;

use EmailOnAcid\Authentication;
use EmailOnAcid\Exception\ApiRequestException;
use EmailOnAcid\Exception\NotFoundException;
use EmailOnAcid\Request\RequestFactory;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class RequestFactoryTest extends TestCase
{

	private $api_key = 'sandbox';
	private $password = 'sandbox';

	public function testGet()
	{
		$url = 'unittests';
		$client = $this->getMockBuilder(Client::class);
		$client->setMethods(['request']);
		$clientMalformedJson = $client->getMock();
		$clientMalformedJson->method('request')->willReturn('malformed json');
		$clientMalformedJson->expects($this->once())->method('request')->with(RequestFactory::METHOD_GET, $url, $this->getOptions());

		$clientRequestException = $client->getMock();
		$clientRequestException->method('request')->willThrowException($this->getMockBuilder(RequestException::class)->disableOriginalConstructor()->getMock());

		$factory = $this->getInstance($clientMalformedJson);
		try {
			$factory->get($url, []);
			$this->fail('Should be throwing exception on malformed json response');
		} catch (ApiRequestException $requestException) {
			$this->assertTrue(true);
		}
		$factory = $this->getInstance($clientRequestException);
		try {
			$factory->get($url, []);
			$this->fail('Should be throwing exception due client setting');
		} catch (ApiRequestException $requestException) {
			$this->assertTrue(true);
		}
		$normalClient = $client->getMock();
		$normalClient->method('request')->willReturn('{"hello":"ahoy"}');
		$normalClient->expects($this->once())->method('request')->with(RequestFactory::METHOD_GET, $url, $this->getOptions());
		$factory = $this->getInstance($normalClient);

		$factory->get($url);


		$normalClient = $client->getMock();
		$normalClient->method('request')->willReturn('{"hello":"ahoy"}');
		$normalClient->expects($this->once())->method('request')->with(RequestFactory::METHOD_GET, $url . '?test=1', $this->getOptions());
		$factory = $this->getInstance($normalClient);

		$factory->get($url, ['test' => 1]);
	}

	private function getOptions(array $json = []): array
	{
		$options['auth'] = [
			$this->api_key,
			$this->password
		];
		$options['headers'] = [
			'Content-type' => 'application/json',
			'Accept'       => 'application/json',
		];
		if($json){
			$options['json'] = $json;
		}
		return $options;
	}

	private function getInstance(Client $mock = NULL): RequestFactory
	{
		return new RequestFactory(
			isset($mock) ? $mock : $this->getMockBuilder(Client::class)->getMock(),
			new Authentication($this->api_key, $this->password)
		);
	}

	public function testPost()
	{
		$url = 'unittests';
		$client = $this->getMockBuilder(Client::class);
		$client->setMethods(['request']);
		$clientMalformedJson = $client->getMock();
		$clientMalformedJson->method('request')->willReturn('malformed json');
		$clientMalformedJson->expects($this->once())->method('request')->with(RequestFactory::METHOD_POST, $url, $this->getOptions());

		$clientRequestException = $client->getMock();
		$clientRequestException->method('request')->willThrowException($this->getMockBuilder(RequestException::class)->disableOriginalConstructor()->getMock());
		$clientRequestException->expects($this->once())->method('request');

		$factory = $this->getInstance($clientMalformedJson);
		try {
			$factory->post($url, []);
			$this->fail('Should be throwing exception on malformed json response');
		} catch (ApiRequestException $requestException) {
			$this->assertTrue(true);
		}
		$factory = $this->getInstance($clientRequestException);
		try {
			$factory->post($url, []);
			$this->fail('Should be throwing exception due client setting');
		} catch (ApiRequestException $requestException) {
			$this->assertTrue(true);
		}
	}

	public function testPut()
	{
		$url = 'unittests';
		$client = $this->getMockBuilder(Client::class);
		$client->setMethods(['request']);
		$clientMalformedJson = $client->getMock();
		$clientMalformedJson->method('request')->willReturn('malformed json');
		$clientMalformedJson->expects($this->once())->method('request')->with(RequestFactory::METHOD_PUT, $url, $this->getOptions());
		$clientMalformedJson->expects($this->once())->method('request');

		$clientRequestException = $client->getMock();
		$clientRequestException->method('request')->willThrowException($this->getMockBuilder(RequestException::class)->disableOriginalConstructor()->getMock());
		$clientRequestException->expects($this->once())->method('request');

		$factory = $this->getInstance($clientMalformedJson);
		try {
			$factory->put($url, []);
			$this->fail('Should be throwing exception on malformed json response');
		} catch (ApiRequestException $requestException) {
			$this->assertTrue(true);
		}
		$factory = $this->getInstance($clientRequestException);
		try {
			$factory->put($url, []);
			$this->fail('Should be throwing exception due client setting');
		} catch (ApiRequestException $requestException) {
			$this->assertTrue(true);
		}
	}

	public function testDelete()
	{
		$url = 'unittests';
		$json = ['test'=>123];
		$client = $this->getMockBuilder(Client::class);
		$client->setMethods(['request']);
		$clientMalformedJson = $client->getMock();
		$clientMalformedJson->method('request')->willReturn('{}');
		$clientMalformedJson->expects($this->once())->method('request')->with(RequestFactory::METHOD_DELETE, $url, $this->getOptions(['test'=>123]));
		$clientMalformedJson->expects($this->once())->method('request');

		$clientRequestException = $client->getMock();
		$clientRequestException->method('request')->willThrowException($this->getMockBuilder(RequestException::class)->disableOriginalConstructor()->getMock());
		$clientRequestException->expects($this->once())->method('request');

		$factory = $this->getInstance($clientMalformedJson);
		$factory->delete($url, $json);


		$factory = $this->getInstance($clientRequestException);
		try {
			$factory->delete($url, []);
			$this->fail('Should be throwing exception due client setting');
		} catch (ApiRequestException $requestException) {
			$this->assertTrue(true);
		}
	}

	public function testObjectResponse()
	{

		$url = 'unittests?';
		$client = $this->getMockBuilder(Client::class);
		$client->setMethods(['request']);
		$clientMock = $client->getMock();

		$stream = $this->getMockBuilder(StreamInterface::class)->getMock();
		$stream->method('getContents')->willReturn('{}');
		$message = $this->getMockBuilder(MessageInterface::class)->getMock();
		$message->method('getBody')->willReturn($stream);

		$clientMock->method('request')->willReturn($message);

		$requestFactory = $this->getInstance($clientMock);
		$result = $requestFactory->get($url, ['test' => 5]);

		$this->assertSame([], $result);

	}

	public function testNotFoundRequest()
	{
		$url = 'unittests?';
		$client = $this->getMockBuilder(Client::class);
		$client->setMethods(['request']);
		$clientMock = $client->getMock();

		$stream = $this->getMockBuilder(StreamInterface::class)->getMock();
		$stream->method('getContents')->willReturn('{"error":{"name":"Not found","message":"is not found"}}');

		$response = $this->getMockBuilder(ResponseInterface::class)
			->setMethods(
				[
					'getStatusCode',
					'withStatus',
					'getReasonPhrase',
					'getProtocolVersion',
					'withProtocolVersion',
					'getHeaders',
					'hasHeader',
					'getHeader',
					'getHeaderLine',
					'withHeader',
					'withAddedHeader',
					'withoutHeader',
					'getBody',
					'withBody'
				]
			)
			->getMock();
		$response->method('getStatusCode')->willReturn(RequestFactory::NOT_FOUND);
		$response->method('getBody')->willReturn($stream);

		$requestException = new RequestException(
			'Test',
			$this->getMockBuilder(RequestInterface::class)->disableOriginalConstructor()->getMock(),
			$response
		);
		$clientMock->method('request')->willThrowException($requestException);
		$this->expectException(NotFoundException::class);

		try {
			$requestFactory = $this->getInstance($clientMock);
			$requestFactory->get($url, ['test' => 5]);
		} catch (NotFoundException $notFoundException) {
			$this->assertSame('Not found - is not found', $notFoundException->getMessage());
			throw $notFoundException;
		}

	}

	public function testNotFoundRequestMalformedJson()
	{
		$url = 'unittests?';
		$client = $this->getMockBuilder(Client::class);
		$client->setMethods(['request']);
		$clientMock = $client->getMock();

		$stream = $this->getMockBuilder(StreamInterface::class)->getMock();
		$stream->method('getContents')->willReturn('{error:{"name":"Not found","message":"is not found"}}');

		$response = $this->getMockBuilder(ResponseInterface::class)
			->setMethods(
				[
					'getStatusCode',
					'withStatus',
					'getReasonPhrase',
					'getProtocolVersion',
					'withProtocolVersion',
					'getHeaders',
					'hasHeader',
					'getHeader',
					'getHeaderLine',
					'withHeader',
					'withAddedHeader',
					'withoutHeader',
					'getBody',
					'withBody'
				]
			)
			->getMock();
		$response->method('getStatusCode')->willReturn(RequestFactory::NOT_FOUND);
		$response->method('getBody')->willReturn($stream);

		$requestException = new RequestException(
			'Test',
			$this->getMockBuilder(RequestInterface::class)->disableOriginalConstructor()->getMock(),
			$response
		);
		$clientMock->method('request')->willThrowException($requestException);
		$this->expectException(ApiRequestException::class);

		try {
			$requestFactory = $this->getInstance($clientMock);
			$requestFactory->get($url, ['test' => 5]);
		} catch (ApiRequestException $notFoundException) {
			throw $notFoundException;
		}

	}


}
