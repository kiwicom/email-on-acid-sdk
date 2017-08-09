<?php


namespace EmailOnAcid\Response;


class CodeAnalysisDiscrepancy
{
	/**
	 * @var string
	 */
	private $property;
	/**
	 * @var string
	 */
	private $message;
	/**
	 * @var int[]
	 */
	private $lines;

	/**
	 * CodeAnalysisDiscrepancy constructor.
	 * @param string $property
	 * @param string $message
	 * @param int[] $lines
	 */
	public function __construct(string $property, string $message, array $lines)
	{
		$this->property = $property;
		$this->message = $message;
		$this->lines = $lines;
	}

	/**
	 * @return string
	 */
	public function getProperty(): string
	{
		return $this->property;
	}

	/**
	 * @return string
	 */
	public function getMessage(): string
	{
		return $this->message;
	}

	/**
	 * @return int[]
	 */
	public function getLines(): array
	{
		return $this->lines;
	}


}