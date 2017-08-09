<?php


namespace EmailOnAcid\Response;


class ReserveSeedList
{
	/**
	 * @var string
	 */
	private $key;
	/**
	 * @var string[]
	 */
	private $address_list;

	/**
	 * ReserveSeedListResponse constructor.
	 * @param string $key
	 * @param string[] $address_list
	 */
	public function __construct(string $key, array $address_list)
	{
		$this->key = $key;
		$this->address_list = $address_list;
	}

	/**
	 * @return string
	 */
	public function getKey(): string
	{
		return $this->key;
	}

	/**
	 * @return string[]
	 */
	public function getAddressList(): array
	{
		return $this->address_list;
	}


}