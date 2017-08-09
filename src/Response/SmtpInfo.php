<?php

namespace EmailOnAcid\Response;


class SmtpInfo implements \JsonSerializable
{
	/**
	 * @var string
	 */
	private $host;
	/**
	 * @var int
	 */
	private $port;
	/**
	 * @var string
	 */
	private $secure;
	/**
	 * @var string
	 */
	private $username;
	/**
	 * @var string
	 */
	private $password;

	/**
	 * SmtpInfo constructor.
	 * @param string $host
	 * @param int $port
	 * @param null|string $secure
	 * @param null|string $username
	 * @param null|string $password
	 */
	public function __construct(
		string $host,
		int $port = 25,
		?string $secure = null,
		?string $username = null,
		?string $password = null)
	{
		$this->host = $host;
		$this->port = $port;
		$this->secure = $secure;
		$this->username = $username;
		$this->password = $password;
	}

	/**
	 * @return string
	 */
	public function getHost(): string
	{
		return $this->host;
	}

	/**
	 * @return int
	 */
	public function getPort(): int
	{
		return $this->port;
	}

	/**
	 * @return string
	 */
	public function getSecure(): string
	{
		return $this->secure;
	}

	/**
	 * @return string
	 */
	public function getUsername(): string
	{
		return $this->username;
	}

	/**
	 * @return string
	 */
	public function getPassword(): string
	{
		return $this->password;
	}

	/**
	 * @return array
	 */
	public function jsonSerialize(): array
	{
		return array_filter(get_object_vars($this));
	}


}