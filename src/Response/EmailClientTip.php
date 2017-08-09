<?php

namespace EmailOnAcid\Response;


class EmailClientTip
{
	/**
	 * @var string
	 */
	private $client;
	/**
	 * @var string
	 */
	private $name;
	/**
	 * @var string
	 */
	private $tip;

	/**
	 * EmailClientTip constructor.
	 * @param string $client
	 * @param string $name
	 * @param string $tip
	 */
	public function __construct(string $client, string $name, string $tip)
	{
		$this->client = $client;
		$this->name = $name;
		$this->tip = $tip;
	}

	/**
	 * @return string
	 */
	public function getClient(): string
	{
		return $this->client;
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function getTip(): string
	{
		return $this->tip;
	}


}