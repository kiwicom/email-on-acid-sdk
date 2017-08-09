<?php

namespace EmailOnAcid\Request;


use EmailOnAcid\Exception\MissingTestContentException;

class EmailTestRequest implements \JsonSerializable
{
	/**
	 * @var string
	 */
	private $subject;
	/**
	 * @var string
	 */
	private $html;
	/**
	 * @var string
	 */
	private $url;
	/**
	 * @var string
	 */
	private $transfer_encoding;
	/**
	 * @var string
	 */
	private $charset;
	/**
	 * @var bool
	 */
	private $free_test = false;
	/**
	 * @var string[]
	 */
	private $tags = [];
	/**
	 * @var bool
	 */
	private $sandbox = false;
	/**
	 * @var string
	 */
	private $reference_id;
	/**
	 * @var string
	 */
	private $customer_id;
	/**
	 * @var string[]
	 */
	private $clients = [];
	/**
	 * @var bool
	 */
	private $image_blocking = false;
	/**
	 * @var SpamTestRequest
	 */
	private $spam;

	/**
	 * EmailTestRequest constructor.
	 * @param string $subject
	 * @param string $html
	 * @param string $url
	 * @throws MissingTestContentException
	 */
	public function __construct(string $subject, ?string $html, ?string $url = null)
	{
		if (empty($html) && empty($url)) {
			throw new MissingTestContentException('Either html or url should be non empty');
		}
		$this->subject = $subject;
		$this->html = $html;
		$this->url = $url;
	}

	/**
	 * @return string
	 */
	public function getSubject(): string
	{
		return $this->subject;
	}

	/**
	 * @return string | null
	 */
	public function getHtml(): ?string
	{
		return $this->html;
	}

	/**
	 * @return string | null
	 */
	public function getUrl(): ?string
	{
		return $this->url;
	}

	/**
	 * @return string | null
	 */
	public function getTransferEncoding(): ?string
	{
		return $this->transfer_encoding;
	}

	/**
	 * @param string $transfer_encoding
	 * @return EmailTestRequest
	 */
	public function setTransferEncoding(string $transfer_encoding): EmailTestRequest
	{
		$this->transfer_encoding = $transfer_encoding;
		return $this;
	}

	/**
	 * @return string | null
	 */
	public function getCharset(): ?string
	{
		return $this->charset;
	}

	/**
	 * @param string $charset
	 * @return EmailTestRequest
	 */
	public function setCharset(string $charset): EmailTestRequest
	{
		$this->charset = $charset;
		return $this;
	}

	/**
	 * @return string | null
	 */
	public function getReferenceId(): ?string
	{
		return $this->reference_id;
	}

	/**
	 * @param string $reference_id
	 * @return EmailTestRequest
	 */
	public function setReferenceId(string $reference_id): EmailTestRequest
	{
		$this->reference_id = $reference_id;
		return $this;
	}

	/**
	 * @return string | null
	 */
	public function getCustomerId(): ?string
	{
		return $this->customer_id;
	}

	/**
	 * @param string $customer_id
	 * @return EmailTestRequest
	 */
	public function setCustomerId(string $customer_id): EmailTestRequest
	{
		$this->customer_id = $customer_id;
		return $this;
	}

	/**
	 * @return string[]
	 */
	public function getClients(): array
	{
		return $this->clients;
	}

	/**
	 * @param string[] $clients
	 * @return EmailTestRequest
	 */
	public function setClients(array $clients): EmailTestRequest
	{
		$this->clients = $clients;
		return $this;
	}

	/**
	 * @return SpamTestRequest
	 */
	public function getSpam(): ?SpamTestRequest
	{
		return $this->spam;
	}

	/**
	 * @param SpamTestRequest $spam
	 * @return EmailTestRequest
	 */
	public function setSpam(SpamTestRequest $spam): EmailTestRequest
	{
		$this->spam = $spam;
		return $this;
	}

	/**
	 * @return string[]
	 */
	public function getTags(): array
	{
		return $this->tags;
	}

	/**
	 * @param string[] $tags
	 * @return EmailTestRequest
	 */
	public function setTags(array $tags): EmailTestRequest
	{
		$this->tags = $tags;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function isFreeTest(): bool
	{
		return $this->free_test;
	}

	/**
	 * @param bool $free_test
	 * @return EmailTestRequest
	 */
	public function setFreeTest(bool $free_test): EmailTestRequest
	{
		$this->free_test = $free_test;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function isSandbox(): bool
	{
		return $this->sandbox;
	}

	/**
	 * @param bool $sandbox
	 * @return EmailTestRequest
	 */
	public function setSandbox(bool $sandbox): EmailTestRequest
	{
		$this->sandbox = $sandbox;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function isImageBlocking(): bool
	{
		return $this->image_blocking;
	}

	/**
	 * @param bool $image_blocking
	 * @return EmailTestRequest
	 */
	public function setImageBlocking(bool $image_blocking): EmailTestRequest
	{
		$this->image_blocking = $image_blocking;
		return $this;
	}

	/**
	 * @return array
	 */
	public function jsonSerialize(): array
	{
		return array_filter(get_object_vars($this));
	}


}