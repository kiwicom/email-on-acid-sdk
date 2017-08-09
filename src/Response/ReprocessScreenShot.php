<?php


namespace EmailOnAcid\Response;


class ReprocessScreenShot
{
	/**
	 * @var string
	 */
	private $client_id;
	/**
	 * @var bool
	 */
	private $success;
	/**
	 * @var int
	 */
	private $remaining_reprocesses;
	/**
	 * @var bool
	 */
	private $regional;
	/**
	 * @var string
	 */
	private $reason;

	/**
	 * ReprocessScreenShotResponse constructor.
	 * @param string $client_id
	 * @param bool $success
	 * @param int $remaining_reprocesses
	 * @param bool $regional
	 * @param string $reason
	 */
	public function __construct(
		string $client_id,
		bool $success,
		int $remaining_reprocesses,
		bool $regional,
		?string $reason = null
	)
	{
		$this->client_id = $client_id;
		$this->success = $success;
		$this->remaining_reprocesses = $remaining_reprocesses;
		$this->regional = $regional;
		$this->reason = $reason;
	}

	/**
	 * @return string
	 */
	public function getClientId(): string
	{
		return $this->client_id;
	}

	/**
	 * @return int
	 */
	public function getRemainingReprocesses(): int
	{
		return $this->remaining_reprocesses;
	}

	/**
	 * @return string
	 */
	public function getReason(): ?string
	{
		return $this->reason;
	}

	/**
	 * @return bool
	 */
	public function isSuccess(): bool
	{
		return $this->success;
	}

	/**
	 * @return bool
	 */
	public function isRegional(): bool
	{
		return $this->regional;
	}


}