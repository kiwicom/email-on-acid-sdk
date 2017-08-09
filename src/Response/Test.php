<?php

namespace EmailOnAcid\Response;


use EmailOnAcid\Exception\TestTypeException;

class Test
{
	const TYPE_EMAIL = 'email-test';
	const TYPE_SPAM = 'spam-test';

	const SPAM_TEST_EOA = 'eoa';
	const SPAM_TEST_SMTP = 'smtp';
	const SPAM_TEST_SEED = 'seed';

	/**
	 * @var string
	 */
	private $id;
	/**
	 * @var \DateTimeImmutable
	 */
	private $date;
	/**
	 * @var string
	 */
	private $type;
	/**
	 * @var string[]
	 */
	private $headers = [];
	/**
	 * @var string[]
	 */
	private $tags = [];

	/**
	 * Test constructor.
	 * @param string $id
	 * @param \DateTimeImmutable $date
	 * @param string $type
	 * @param string[] $headers
	 * @param string[] $tags
	 * @throws TestTypeException
	 */
	public function __construct(string $id, \DateTimeImmutable $date, string $type, array $headers, array $tags)
	{
		$this->id = $id;
		$this->date = $date;
		if (!in_array($type, [Test::TYPE_EMAIL, Test::TYPE_SPAM])) {
			throw new TestTypeException(
				sprintf(
					'Unknown test type %s',
					$type
				)
			);
		}
		$this->type = $type;
		$this->headers = $headers;
		$this->tags = $tags;
	}

	/**
	 * @return string
	 */
	public function getId(): string
	{
		return $this->id;
	}

	/**
	 * @return \DateTimeImmutable
	 */
	public function getDate(): \DateTimeImmutable
	{
		return $this->date;
	}

	/**
	 * @return string
	 */
	public function getType(): string
	{
		return $this->type;
	}

	/**
	 * @return string[]
	 */
	public function getHeaders(): array
	{
		return $this->headers;
	}

	/**
	 * @return string[]
	 */
	public function getTags(): array
	{
		return $this->tags;
	}


}