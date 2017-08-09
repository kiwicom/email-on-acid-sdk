<?php

namespace EmailOnAcid\Request;


use EmailOnAcid\Exception\MissingSmtpInfoException;
use EmailOnAcid\Response\SmtpInfo;
use EmailOnAcid\Response\Test;

class SpamTestRequest extends EmailTestRequest implements \JsonSerializable
{
	/**
	 * @var string
	 */
	private $test_method;
	/**
	 * @var SmtpInfo
	 */
	private $smtp_info;

	/**
	 * @var string
	 */
	private $from_address;
	/**
	 * @var string
	 */
	private $key;

	/**
	 * @return SmtpInfo | null
	 */
	public function getSmtpInfo(): ?SmtpInfo
	{
		return $this->smtp_info;
	}

	/**
	 * @param SmtpInfo $smtp_info
	 */
	public function setSmtpInfo(SmtpInfo $smtp_info)
	{
		$this->smtp_info = $smtp_info;
	}

	/**
	 * @return string | null
	 */
	public function getTestMethod(): ?string
	{
		return $this->test_method;
	}

	/**
	 * @param string $test_method
	 * @return SpamTestRequest
	 */
	public function setTestMethod(string $test_method): SpamTestRequest
	{
		$this->test_method = $test_method;
		return $this;
	}

	/**
	 * @return string | null
	 */
	public function getFromAddress(): ?string
	{
		return $this->from_address;
	}

	/**
	 * @param string $from_address
	 * @return SpamTestRequest
	 */
	public function setFromAddress(string $from_address): SpamTestRequest
	{
		$this->from_address = $from_address;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getKey(): string
	{
		return $this->key;
	}

	/**
	 * @param string $key
	 * @return SpamTestRequest
	 */
	public function setKey(string $key): SpamTestRequest
	{
		$this->key = $key;
		return $this;
	}

	/**
	 * @return array
	 * @throws MissingSmtpInfoException
	 */
	public function jsonSerialize(): array
	{
		$data = parent::jsonSerialize();
		if ($this->test_method === Test::SPAM_TEST_SMTP && empty($this->smtp_info)) {
			throw new MissingSmtpInfoException('Test method smtp require smtp host configuration via SmtpInfo');
		}
		return array_filter(array_merge($data, get_object_vars($this)));
	}


}