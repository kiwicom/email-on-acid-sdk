<?php

namespace EmailOnAcid\Response;

class NewEmailTest
{
	/**
	 * @var string
	 */
	private $id;
	/**
	 * @var string
	 */
	private $reference_id;
	/**
	 * @var string
	 */
	private $customer_id;
	/**
	 * @var NewSpamTest
	 */
	private $spam;

	/**
	 * NewEmailTestResponse constructor.
	 * @param string $id
	 * @param string $reference_id
	 * @param string $customer_id
	 * @param NewSpamTest $spam
	 */
	public function __construct(string $id, ?string $reference_id = null, ?string $customer_id = null, NewSpamTest $spam = null)
	{
		$this->id = $id;
		$this->reference_id = $reference_id;
		$this->customer_id = $customer_id;
		$this->spam = $spam;
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
	public function getReferenceId(): ?string
	{
		return $this->reference_id;
	}

	/**
	 * @return string
	 */
	public function getCustomerId(): ?string
	{
		return $this->customer_id;
	}

	/**
	 * @return NewSpamTest
	 */
	public function getSpam(): ?NewSpamTest
	{
		return $this->spam;
	}


}