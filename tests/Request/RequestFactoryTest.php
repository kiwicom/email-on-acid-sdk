<?php

namespace EmailOnAcid\Tests\Request;

use BlastCloud\Guzzler\UsesGuzzler;
use EmailOnAcid\Authentication;
use EmailOnAcid\Exception\ApiRequestException;
use EmailOnAcid\Exception\NotFoundException;
use EmailOnAcid\Request\RequestFactory;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class RequestFactoryTest extends TestCase
{

    use UsesGuzzler;

	private $api_key = 'sandbox';
	private $password = 'sandbox';

	public function testGetResponseWithInvalidJsonResponse(): void {

	    $url = 'unittests';
        $this->guzzler->expects($this->once())
            ->get($url)
            ->willRespond(
                new Response(200, [], 'malformed json')
            );

        $factory = $this->getInstance($this->guzzler->getClient($this->getOptions()));
        $this->expectException(ApiRequestException::class);
        $factory->get($url, []);
    }

	public function testGet()
	{
		$url = 'unittests';

		$this->guzzler->expects($this->once())
            ->get('unittests')
            ->willRespond(
                new Response(200, [], '{"hello":"ahoy"}')
            );

		$factory = $this->getInstance($this->guzzler->getClient($this->getOptions()));
		$factory->get($url);
	}

	public function testGetRequestExceptionThrowsApiException(): void {

        $url = 'unittests';

        $this->guzzler->expects($this->once())
            ->get('unittests')
            ->willRespond(
                new Response(400)
            );

        $factory = $this->getInstance($this->guzzler->getClient($this->getOptions()));

        $this->expectException(ApiRequestException::class);
        $factory->get($url);
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

    public function testPostResponseWithInvalidJsonResponse(): void {

        $url = 'unittests';
        $this->guzzler->expects($this->once())
            ->post($url)
            ->willRespond(
                new Response(200, [], 'malformed json')
            );

        $factory = $this->getInstance($this->guzzler->getClient($this->getOptions()));
        $this->expectException(ApiRequestException::class);
        $factory->post($url, []);
    }

    public function testPostRequestExceptionThrowsApiException(): void {

        $url = 'unittests';

        $this->guzzler->expects($this->once())
            ->post('unittests')
            ->willRespond(
                new Response(400)
            );

        $factory = $this->getInstance($this->guzzler->getClient($this->getOptions()));

        $this->expectException(ApiRequestException::class);
        $factory->post($url);
    }

	public function testPost()
	{
        $url = 'unittests';

        $this->guzzler->expects($this->once())
            ->post('unittests')
            ->willRespond(
                new Response(200, [], '{"hello":"ahoy"}')
            );

        $factory = $this->getInstance($this->guzzler->getClient($this->getOptions()));
        $factory->post($url);
	}


    public function testPutResponseWithInvalidJsonResponse(): void {

        $url = 'unittests';
        $this->guzzler->expects($this->once())
            ->put($url)
            ->willRespond(
                new Response(200, [], 'malformed json')
            );

        $factory = $this->getInstance($this->guzzler->getClient($this->getOptions()));
        $this->expectException(ApiRequestException::class);
        $factory->put($url, []);
    }

    public function testPutRequestExceptionThrowsApiException(): void {

        $url = 'unittests';

        $this->guzzler->expects($this->once())
            ->put('unittests')
            ->willRespond(
                new Response(400)
            );

        $factory = $this->getInstance($this->guzzler->getClient($this->getOptions()));

        $this->expectException(ApiRequestException::class);
        $factory->put($url);
    }

    public function testPut()
    {
        $url = 'unittests';

        $this->guzzler->expects($this->once())
            ->put('unittests')
            ->willRespond(
                new Response(200, [], '{"hello":"ahoy"}')
            );

        $factory = $this->getInstance($this->guzzler->getClient($this->getOptions()));
        $factory->put($url);
    }







    public function testDeleteResponseWithInvalidJsonResponse(): void {

        $url = 'unittests';
        $this->guzzler->expects($this->once())
            ->delete($url)
            ->willRespond(
                new Response(200, [], 'malformed json')
            );

        $factory = $this->getInstance($this->guzzler->getClient($this->getOptions()));
        $this->expectException(ApiRequestException::class);
        $factory->delete($url, []);
    }

    public function testDeleteRequestExceptionThrowsApiException(): void {

        $url = 'unittests';

        $this->guzzler->expects($this->once())
            ->delete('unittests')
            ->willRespond(
                new Response(400)
            );

        $factory = $this->getInstance($this->guzzler->getClient($this->getOptions()));

        $this->expectException(ApiRequestException::class);
        $factory->delete($url);
    }

    public function testDelete()
    {
        $url = 'unittests';

        $this->guzzler->expects($this->once())
            ->delete('unittests')
            ->willRespond(
                new Response(200, [], '{"hello":"ahoy"}')
            );

        $factory = $this->getInstance($this->guzzler->getClient($this->getOptions()));
        $factory->delete($url);
    }

	public function testObjectResponse()
	{

        $url = 'unittests';
	    $client = $this->guzzler->getClient();
	    $this->guzzler->expects($this->once())
            ->get($url . '?test=5')
            ->willRespond(
                new Response(200, [], '{}')
            );

		$requestFactory = $this->getInstance($client);
		$result = $requestFactory->get($url, ['test' => 5]);

		$this->assertSame([], $result);

	}

	public function testNotFoundRequest()
	{
		$url = 'unittests?';
		$client = $this->getMockBuilder(Client::class);
		$client->onlyMethods(['request']);
		$clientMock = $client->getMock();

		$stream = $this->getMockBuilder(StreamInterface::class)->getMock();
		$stream->method('getContents')->willReturn('{"error":{"name":"Not found","message":"is not found"}}');

		$response = $this->getMockBuilder(ResponseInterface::class)
			->onlyMethods(
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
		$client->onlyMethods(['request']);
		$clientMock = $client->getMock();

		$stream = $this->getMockBuilder(StreamInterface::class)->getMock();
		$stream->method('getContents')->willReturn('{error:{"name":"Not found","message":"is not found"}}');

		$response = $this->getMockBuilder(ResponseInterface::class)
			->onlyMethods(
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
