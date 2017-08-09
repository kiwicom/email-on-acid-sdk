<?php

namespace EmailOnAcid;


abstract class BaseSettings
{
	/**
	 * @var string
	 */
	private static $date_time_format = 'Y-m-d H:i:s';

	/**
	 * @return string
	 */
	public static function getDateTimeFormat(): string
	{
		return self::$date_time_format;
	}


}