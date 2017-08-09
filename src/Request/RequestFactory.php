<?php

namespace EmailOnAcid\Request;


use EmailOnAcid\Authentication;
use EmailOnAcid\Exception\ApiRequestException;
use EmailOnAcid\Exception\NotFoundException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class RequestFactory
{

	const NOT_FOUND = 404;

	const METHOD_GET = 'GET',
		METHOD_POST = 'POST',
		METHOD_PUT = 'PUT',
		METHOD_DELETE = 'DELETE';

	/**
	 * @var Client
	 */
	private $client;

	/**
	 * @var Authentication
	 */
	private $authentication;

	/**
	 * @var int
	 */
	private $timeout;

	/**
	 * RequestFactory constructor.
	 * @param Client $client
	 * @param Authentication $authentication
	 * @param int $timeout
	 */
	public function __construct(Client $client, Authentication $authentication, $timeout = 10)
	{
		$this->client = $client;
		$this->authentication = $authentication;
		$this->timeout = $timeout;
	}

	/**
	 * @param string $url
	 * @param array $data
	 * @return array
	 */
	public function delete(string $url, array $data = []): array
	{
		return $this->doRequest(RequestFactory::METHOD_DELETE, $url, $data);
	}

	/**
	 * @param string $method
	 * @param string $url
	 * @param array $data
	 * @return array
	 * @throws ApiRequestException
	 * @throws NotFoundException
	 */
	private function doRequest(string $method, string $url, array $data = []): array
	{
		$options = [];
		$options['auth'] = [
			$this->authentication->getApiKey(),
			$this->authentication->getPassword()
		];
		$options['headers'] = [
			'Content-type' => 'application/json',
			'Accept'       => 'application/json',
		];
		if ($data && $method !== RequestFactory::METHOD_GET) {
			$options['json'] = $data;
		} else {
			$url = $this->addQueryString($url, $data);
		}
		try {
			$response = $this->client->request($method, $url, $options);
			if (!is_string($response)) {
				$response = $response->getBody()->getContents();
			}
			$result = json_decode($response, TRUE);
			if ($result === null) {
				throw new ApiRequestException('Malformed json response');
			}
			return $result;
		} catch (RequestException $requestException) {
			if ($requestException->getCode() === RequestFactory::NOT_FOUND) {
				$errorContent = json_decode(
					$requestException->getResponse()
						->getBody()
						->getContents(),
					TRUE
				);
				if ($errorContent === null) {
					throw new ApiRequestException('Malformed json response');
				}
				throw new NotFoundException(
					sprintf(
						'%s - %s',
						$errorContent['error']['name'],
						$errorContent['error']['message']
					)
				);
			} else {
				throw new ApiRequestException($requestException->getMessage());
			}
		}
	}

	/**
	 * @param string $url
	 * @param array $query_data
	 * @return string
	 */
	private function addQueryString(string $url, array $query_data): string
	{
		if (empty($query_data)) {
			return $url;
		}
		$query_string = http_build_query($query_data);
		if (preg_match('/\?/', $url)) {
			$url .= '&';
		} else {
			$url .= '?';
		}
		return $url . $query_string;
	}

	/**
	 * @param string $url
	 * @param array $data
	 * @return array
	 */
	public function get(string $url, array $data = []): array
	{
		return $this->doRequest(RequestFactory::METHOD_GET, $url, $data);
	}

	/**
	 * @param string $url
	 * @param array $data
	 * @return array
	 */
	public function post(string $url, array $data = []): array
	{
		return $this->doRequest(RequestFactory::METHOD_POST, $url, $data);
	}

	/**
	 * @param string $url
	 * @param array $data
	 * @return array
	 */
	public function put(string $url, array $data = []): array
	{
		return $this->doRequest(RequestFactory::METHOD_PUT, $url, $data);
	}

}