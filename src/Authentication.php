<?php

namespace EmailOnAcid;


class Authentication
{
	/**
	 * @var string
	 */
	private $api_key;

	/**
	 * @var string
	 */
	private $password;

	/**
	 * Authentication constructor.
	 * @param string $api_key
	 * @param string $password
	 */
	public function __construct(string $api_key, string $password)
	{
		$this->api_key = $api_key;
		$this->password = $password;
	}

	/**
	 * @return string
	 */
	public function getApiKey(): string
	{
		return $this->api_key;
	}

	/**
	 * @return string
	 */
	public function getPassword(): string
	{
		return $this->password;
	}


}