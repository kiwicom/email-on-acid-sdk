<?php


namespace EmailOnAcid\Response;


class LinkValidation
{
	/**
	 * @var LinkValidationLink[]
	 */
	private $links;
	/**
	 * @var string[]
	 */
	private $uribl;

	/**
	 * LinkValidationResponse constructor.
	 * @param LinkValidationLink[] $links
	 * @param string[] $uribl
	 */
	public function __construct(array $links, array $uribl)
	{
		$this->links = $links;
		$this->uribl = $uribl;
	}

	/**
	 * @return LinkValidationLink[]
	 */
	public function getLinks(): array
	{
		return $this->links;
	}

	/**
	 * @return string[]
	 */
	public function getUribl(): array
	{
		return $this->uribl;
	}


}