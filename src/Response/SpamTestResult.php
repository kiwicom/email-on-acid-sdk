<?php


namespace EmailOnAcid\Response;


class SpamTestResult
{
	const SPAM_LEVEL_SPAM = 1,
		SPAM_LEVEL_NEUTRAL = 0,
		SPAM_LEVEL_NOT_SPAM = -1;

	/**
	 * @var string
	 */
	private $client;
	/**
	 * @var string
	 */
	private $type;
	/**
	 * @var int | null
	 */
	private $spam;
	/**
	 * @var string | null
	 */
	private $details;

	/**
	 * SpamTestResult constructor.
	 * @param string $client
	 * @param string $type
	 * @param int $spam
	 * @param string | array $details
	 */
	public function __construct(string $client, string $type, ?int $spam,$details)
	{
		$this->client = $client;
		$this->type = $type;
		$this->spam = $spam;
		if(isset($details)){
			if(!is_array($details) && !is_string($details)){
				throw new \InvalidArgumentException('Expecting string or array as details');
			}
			if(!is_string($details)){
				$this->details = json_encode($details);
			}else{
				$this->details = $details;
			}
		}
	}

	/**
	 * @return string
	 */
	public function getClient(): string
	{
		return $this->client;
	}

	/**
	 * @return string
	 */
	public function getType(): string
	{
		return $this->type;
	}

	/**
	 * @return int
	 */
	public function getSpam(): ?int
	{
		return $this->spam;
	}

	/**
	 * @return string
	 */
	public function getDetails(): ?string
	{
		return $this->details;
	}


}