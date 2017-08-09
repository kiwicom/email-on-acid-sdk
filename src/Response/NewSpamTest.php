<?php

namespace EmailOnAcid\Response;


class NewSpamTest
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
	 * @var string[]
	 */
	private $addresses;

	/**
	 * NewSpamTest constructor.
	 * @param string $id
	 * @param null|string $reference_id
	 * @param null|string $customer_id
	 * @param array $addresses
	 */
	public function __construct(string $id, ?string $reference_id = null, ?string $customer_id = null, array $addresses = [])
	{
		$this->id = $id;
		$this->reference_id = $reference_id;
		$this->customer_id = $customer_id;
		$this->addresses = $addresses;
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
	 * @return string[]
	 */
	public function getAddresses(): array
	{
		return $this->addresses;
	}


}