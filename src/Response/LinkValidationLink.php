<?php


namespace EmailOnAcid\Response;


class LinkValidationLink
{
	/**
	 * @var string
	 */
	private $url;
	/**
	 * @var string
	 */
	private $type;
	/**
	 * @var array
	 */
	private $redirects = [];
	/**
	 * @var int
	 */
	private $status;
	/**
	 * @var string
	 */
	private $mime;
	/**
	 * @var bool
	 */
	private $warning;
	/**
	 * @var bool
	 */
	private $alt;
	/**
	 * @var string | null
	 */
	private $error;

	/**
	 * LinkValidationLink constructor.
	 * @param string $url
	 * @param string $type
	 * @param array $redirects
	 * @param int $status
	 * @param string $mime
	 * @param bool $warning
	 * @param bool $alt
	 * @param bool|string $error
	 */
	public function __construct(
		string $url,
		string $type,
		array $redirects,
		int $status,
		string $mime,
		bool $warning,
		bool $alt,
		$error)
	{
		$this->url = $url;
		$this->type = $type;
		$this->redirects = $redirects;
		$this->status = $status;
		$this->mime = $mime;
		$this->warning = $warning;
		$this->alt = $alt;
		if($error !== false){
			$this->error = $error;
		}
	}

	/**
	 * @return string
	 */
	public function getUrl(): string
	{
		return $this->url;
	}

	/**
	 * @return string
	 */
	public function getType(): string
	{
		return $this->type;
	}

	/**
	 * @return array
	 */
	public function getRedirects(): array
	{
		return $this->redirects;
	}

	/**
	 * @return int
	 */
	public function getStatus(): int
	{
		return $this->status;
	}

	/**
	 * @return string
	 */
	public function getMime(): string
	{
		return $this->mime;
	}

	/**
	 * @return bool
	 */
	public function isWarning(): bool
	{
		return $this->warning;
	}

	/**
	 * @return bool
	 */
	public function haveAlt(): bool
	{
		return $this->alt;
	}

	/**
	 * @return null|string
	 */
	public function getError() : ?string
	{
		return $this->error;
	}




}