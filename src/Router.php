<?php

namespace EmailOnAcid;

use EmailOnAcid\Exception\RouterException;

/**
 * Class Router
 * @package EmailOnAcid
 */
abstract class Router
{

	/**
	 * @var string
	 */
	private static $api_endpoint = 'https://api.emailonacid.com/v5';

	/**
	 * @return string
	 */
	public static function getApiEndpoint(): string
	{
		return self::$api_endpoint;
	}

	/**
	 * @param $action
	 * @param array $parameters
	 * @return string
	 * @throws RouterException
	 */
	public static function buildUrl($action, array $parameters = []): string
	{
		foreach ($parameters as $key => $value) {
			if (!is_scalar($value)) {
				throw new \InvalidArgumentException(
					sprintf(
						'Invalid argument supplied in parameters on key "%s" , expecting scalar value got "%s"',
						$key,
						gettype($value)
					)
				);
			}
			$action = str_replace('[/<' . $key . '>]', '/' . $value, $action);
			$action = str_replace('<' . $key . '>', $value, $action);
		}
		$action = preg_replace('/\[\/<[^\s]+>\]/', '', $action);
		if (preg_match('/<([^\s]+)>/', $action, $matches)) {
			throw new RouterException(sprintf(
				'Missing parameter "%s"',
				$matches[1]
			));
		}
		$action = trim($action,'/');
		return sprintf(
			'%s/%s',
			self::$api_endpoint,
			$action
		);
	}

}