<?php namespace App\helpers;

defined("BASEPATH") or die("ACCESS DENIED");

class Ajax
{
	public static function isAjax()
	{
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
}