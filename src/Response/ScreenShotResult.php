<?php


namespace EmailOnAcid\Response;

class ScreenShotResult
{
	/**
	 * @var string
	 */
	private $type;
	/**
	 * @var string
	 */
	private $screen_shot;

	/**
	 * ScreenshotCollection constructor.
	 * @param string $type
	 * @param string $screen_shot
	 */
	public function __construct(string $type, string $screen_shot)
	{
		$this->type = $type;
		$this->screen_shot = $screen_shot;
	}

	/**
	 * @return string
	 */
	public function getType(): string
	{
		return $this->type;
	}

	/**
	 * @return string
	 */
	public function getScreenShot(): string
	{
		return $this->screen_shot;
	}


}