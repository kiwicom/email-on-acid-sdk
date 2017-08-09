<?php

namespace EmailOnAcid\Request;


use EmailOnAcid\BaseSettings;

class TestSearchRequest implements \JsonSerializable
{
	/**
	 * @var \DateTimeImmutable
	 */
	private $from;
	/**
	 * @var \DateTimeImmutable
	 */
	private $to;
	/**
	 * @var string
	 */
	private $subject;
	/**
	 * @var string[]
	 */
	private $headers;
	/**
	 * @var string[]
	 */
	private $tags;
	/**
	 * @var string
	 */
	private $type;
	/**
	 * @var int
	 */
	private $results;
	/**
	 * @var int
	 */
	private $page;

	/**
	 * @return \DateTimeImmutable
	 */
	public function getFrom(): \DateTimeImmutable
	{
		return $this->from;
	}

	/**
	 * @param \DateTimeImmutable $from
	 * @return TestSearchRequest
	 */
	public function setFrom(\DateTimeImmutable $from): TestSearchRequest
	{
		$this->from = $from;
		return $this;
	}

	/**
	 * @return \DateTimeImmutable
	 */
	public function getTo(): \DateTimeImmutable
	{
		return $this->to;
	}

	/**
	 * @param \DateTimeImmutable $to
	 * @return TestSearchRequest
	 */
	public function setTo(\DateTimeImmutable $to): TestSearchRequest
	{
		$this->to = $to;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getSubject(): string
	{
		return $this->subject;
	}

	/**
	 * @param string $subject
	 * @return TestSearchRequest
	 */
	public function setSubject(string $subject): TestSearchRequest
	{
		$this->subject = $subject;
		return $this;
	}

	/**
	 * @return string[]
	 */
	public function getHeaders(): array
	{
		return $this->headers;
	}

	/**
	 * @param string[] $headers
	 * @return TestSearchRequest
	 */
	public function setHeaders(array $headers): TestSearchRequest
	{
		$this->headers = $headers;
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
	 * @return TestSearchRequest
	 */
	public function setTags(array $tags): TestSearchRequest
	{
		$this->tags = $tags;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getType(): string
	{
		return $this->type;
	}

	/**
	 * @param string $type
	 * @return TestSearchRequest
	 */
	public function setType(string $type): TestSearchRequest
	{
		$this->type = $type;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getResults(): int
	{
		return $this->results;
	}

	/**
	 * @param int $results
	 * @return TestSearchRequest
	 */
	public function setResults(int $results): TestSearchRequest
	{
		$this->results = $results;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getPage(): int
	{
		return $this->page;
	}

	/**
	 * @param int $page
	 * @return TestSearchRequest
	 */
	public function setPage(int $page): TestSearchRequest
	{
		$this->page = $page;
		return $this;
	}

	/**
	 * @return array
	 */
	public function jsonSerialize(): array
	{
		$data = [];
		foreach (get_object_vars($this) as $property => $value) {
			if ($value instanceof \DateTimeImmutable) {
				$value = $value->format(BaseSettings::getDateTimeFormat());
			}
			$data[$property] = $value;
		}
		return array_filter($data);
	}
}