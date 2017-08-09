<?php


namespace EmailOnAcid\Response;


class TestStatusDetail
{
	/**
	 * @var \DateTimeImmutable
	 */
	private $submitted;
	/**
	 * @var \DateTimeImmutable
	 */
	private $completed;
	/**
	 * @var string
	 */
	private $bounce_code;
	/**
	 * @var string
	 */
	private $bounce_message;

	/**
	 * @var int
	 */
	private $attempts;

	/**
	 * TestStatusDetail constructor.
	 * @param \DateTimeImmutable $submitted
	 * @param int $attempts
	 * @param \DateTimeImmutable|null $completed
	 * @param null|string $bounce_code
	 * @param null|string $bounce_message
	 */
	public function __construct(
		\DateTimeImmutable $submitted,
		?int $attempts = null,
		?\DateTimeImmutable $completed = null,
		?string $bounce_code = null,
		?string $bounce_message = null
	)
	{
		$this->submitted = $submitted;
		$this->attempts = $attempts;
		$this->completed = $completed;
		$this->bounce_code = $bounce_code;
		$this->bounce_message = $bounce_message;
	}

	/**
	 * @return \DateTimeImmutable
	 */
	public function getSubmitted(): \DateTimeImmutable
	{
		return $this->submitted;
	}

	/**
	 * @return \DateTimeImmutable
	 */
	public function getCompleted(): \DateTimeImmutable
	{
		return $this->completed;
	}

	/**
	 * @return string
	 */
	public function getBounceCode(): ?string
	{
		return $this->bounce_code;
	}

	/**
	 * @return string
	 */
	public function getBounceMessage(): ?string
	{
		return $this->bounce_message;
	}

	/**
	 * @return int
	 */
	public function getAttempts(): ?int
	{
		return $this->attempts;
	}


}