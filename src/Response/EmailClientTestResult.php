<?php

namespace EmailOnAcid\Response;


class EmailClientTestResult
{
	const STATUS_PROCESS = 'Processing',
		STATUS_COMPLETED = 'Completed',
		STATUS_BOUNCED = 'Bounced';

	/**
	 * @var string
	 */
	private $id;
	/**
	 * @var string
	 */
	private $display_name;
	/**
	 * @var string
	 */
	private $client;
	/**
	 * @var string
	 */
	private $os;
	/**
	 * @var string
	 */
	private $category;
	/**
	 * @var string
	 */
	private $browser;
	/**
	 * @var ScreenShotResult[]
	 */
	private $screenshots;
	/**
	 * @var string
	 */
	private $thumbnail;
	/**
	 * @var string
	 */
	private $status;
	/**
	 * @var TestStatusDetail
	 */
	private $status_detail;

	/**
	 * EmailClientTestResult constructor.
	 * @param string $client_id
	 * @param string $display_name
	 * @param string $client
	 * @param string $os
	 * @param string $category
	 * @param string $browser
	 * @param ScreenShotResult[] $screenshots
	 * @param string $thumbnail
	 * @param string $status
	 * @param TestStatusDetail $status_detail
	 */
	public function __construct(
		string $client_id,
		string $display_name,
		string $client,
		string $os,
		string $category,
		TestStatusDetail $status_detail,
		?string $browser,
		array $screenshots = [],
		?string $thumbnail = null,
		?string $status = null
	)
	{
		$this->id = $client_id;
		$this->display_name = $display_name;
		$this->client = $client;
		$this->os = $os;
		$this->category = $category;
		$this->browser = $browser;
		$this->screenshots = array_map(function (ScreenShotResult $result) {
			return $result;
		}, $screenshots);
		$this->thumbnail = $thumbnail;
		$this->status = $status;
		$this->status_detail = $status_detail;
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
	public function getDisplayName(): string
	{
		return $this->display_name;
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
	public function getOs(): string
	{
		return $this->os;
	}

	/**
	 * @return string
	 */
	public function getCategory(): string
	{
		return $this->category;
	}

	/**
	 * @return string
	 */
	public function getBrowser(): ?string
	{
		return $this->browser;
	}

	/**
	 * @return ScreenShotResult[]
	 */
	public function getScreenshots(): array
	{
		return $this->screenshots;
	}

	/**
	 * @return string
	 */
	public function getThumbnail(): ?string
	{
		return $this->thumbnail;
	}

	/**
	 * @return string
	 */
	public function getStatus(): ?string
	{
		return $this->status;
	}

	/**
	 * @return TestStatusDetail
	 */
	public function getStatusDetail(): TestStatusDetail
	{
		return $this->status_detail;
	}


}