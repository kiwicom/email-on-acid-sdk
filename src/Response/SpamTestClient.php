<?php


namespace EmailOnAcid\Response;


class SpamTestClient
{
	const SPAM_TEST_TYPE_B2B = 'b2b',
		SPAM_TEST_TYPE_B2C = 'b2c';
	/**
	 * @var string
	 */
	private $client;
	/**
	 * @var string
	 */
	private $type;
	/**
	 * @var string
	 */
	private $description;

	/**
	 * SpamTestClient constructor.
	 * @param string $client
	 * @param string $type
	 * @param string $description
	 */
	public function __construct(string $client, string $type, string $description)
	{
		$this->client = $client;
		if (!in_array($type, [SpamTestClient::SPAM_TEST_TYPE_B2B, SpamTestClient::SPAM_TEST_TYPE_B2C])) {
			throw new \InvalidArgumentException('Invalid type for spam test client');
		}
		$this->type = $type;
		$this->description = $description;
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
	public function getType(): string
	{
		return $this->type;
	}

	/**
	 * @return string
	 */
	public function getDescription(): string
	{
		return $this->description;
	}


}