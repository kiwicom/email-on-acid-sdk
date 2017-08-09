<?php

namespace EmailOnAcid\Response;


class NewDefaultClients
{
	/**
	 * @var string[]
	 */
	private $clients;

	/**
	 * @var string[]
	 */
	private $warnings;

	/**
	 * NewDefaultClientsResponse constructor.
	 * @param string[] $clients
	 * @param string[] $warnings
	 */
	public function __construct(array $clients, array $warnings)
	{
		$this->clients = $clients;
		$this->warnings = $warnings;
	}

	/**
	 * @return string[]
	 */
	public function getClients(): array
	{
		return $this->clients;
	}

	/**
	 * @return string[]
	 */
	public function getWarnings(): array
	{
		return $this->warnings;
	}


}