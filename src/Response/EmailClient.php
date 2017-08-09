<?php

namespace EmailOnAcid\Response;


class EmailClient
{
	/**
	 * @var string
	 */
	private $id;
	/**
	 * @var string
	 */
	private $client;
	/**
	 * @var string
	 */
	private $os;
	/**
	 * @var string
	 */
	private $category;
	/**
	 * @var string
	 */
	private $browser;
	/**
	 * @var bool
	 */
	private $rotate;
	/**
	 * @var bool
	 */
	private $image_blocking;
	/**
	 * @var bool
	 */
	private $free;
	/**
	 * @var bool
	 */
	private $default;

	/**
	 * EmailClient constructor.
	 * @param string $id
	 * @param string $client
	 * @param string $os
	 * @param string $category
	 * @param string $browser
	 * @param bool $rotate
	 * @param bool $image_blocking
	 * @param bool $free
	 * @param bool $default
	 */
	public function __construct(
		string $id,
		string $client,
		string $os,
		string $category,
		string $browser = '',
		bool $rotate = false,
		bool $image_blocking = false,
		bool $free = false,
		bool $default = false)
	{
		$this->id = $id;
		$this->client = $client;
		$this->os = $os;
		$this->category = $category;
		$this->browser = $browser;
		$this->rotate = $rotate;
		$this->image_blocking = $image_blocking;
		$this->free = $free;
		$this->default = $default;
	}

	/**
	 * @return string
	 */
	public function getId(): string
	{
		return $this->id;
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
	public function getOs(): string
	{
		return $this->os;
	}

	/**
	 * @return string
	 */
	public function getCategory(): string
	{
		return $this->category;
	}

	/**
	 * @return string
	 */
	public function getBrowser(): string
	{
		return $this->browser;
	}

	/**
	 * @return bool
	 */
	public function isRotate(): bool
	{
		return $this->rotate;
	}

	/**
	 * @return bool
	 */
	public function isImageBlocking(): bool
	{
		return $this->image_blocking;
	}

	/**
	 * @return bool
	 */
	public function isFree(): bool
	{
		return $this->free;
	}

	/**
	 * @return bool
	 */
	public function isDefault(): bool
	{
		return $this->default;
	}


}