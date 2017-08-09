<?php


namespace EmailOnAcid\Response;


class TestContent
{

	/**
	 * @var string
	 */
	private $content;

	/**
	 * TestContentResponse constructor.
	 * @param string $content
	 */
	public function __construct(string $content)
	{
		$this->content = $content;
	}

	/**
	 * @return string
	 */
	public function getContent(): string
	{
		return $this->content;
	}


}