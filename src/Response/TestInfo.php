<?php

namespace EmailOnAcid\Response;


class TestInfo
{
	/**
	 * @var string
	 */
	private $subject;
	/**
	 * @var \DateTimeImmutable
	 */
	private $date;
	/**
	 * @var string[]
	 */
	private $completed = [];
	/**
	 * @var string[]
	 */
	private $processing = [];
	/**
	 * @var string[]
	 */
	private $bounced = [];

	/**
	 * TestInfo constructor.
	 * @param string $subject
	 * @param \DateTimeImmutable $date
	 * @param string[] $completed
	 * @param string[] $processing
	 * @param string[] $bounced
	 */
	public function __construct(string $subject, \DateTimeImmutable $date, array $completed = [], array $processing = [], array $bounced = [])
	{
		$this->subject = $subject;
		$this->date = $date;
		$this->completed = $completed;
		$this->processing = $processing;
		$this->bounced = $bounced;
	}

	/**
	 * @return string
	 */
	public function getSubject(): string
	{
		return $this->subject;
	}

	/**
	 * @return \DateTimeImmutable
	 */
	public function getDate(): \DateTimeImmutable
	{
		return $this->date;
	}

	/**
	 * @return string[]
	 */
	public function getCompleted(): array
	{
		return $this->completed;
	}

	/**
	 * @return string[]
	 */
	public function getProcessing(): array
	{
		return $this->processing;
	}

	/**
	 * @return string[]
	 */
	public function getBounced(): array
	{
		return $this->bounced;
	}


}