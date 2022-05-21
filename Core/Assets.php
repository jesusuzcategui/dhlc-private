<?php namespace Core;

defined("BASEPATH") or die("Access denied");

USE Core\Jdev;

class Assets
{
	public static $css = [];
	public static $js = [];

	public function __construct(){
		$config = Jdev::getConfig();
		self::$css = $config['css'];
		self::$js  = $config['js'];
	}

	public static function setStyleSheet($path)
	{
		array_push(self::$css, $path);
	}

	public static function delStyleSheet($path)
	{
		unset(self::$css[$path]);
	}

	public static function setJavaScript($path)
	{
		array_push(self::$js, $path);
	}

	public static function getStyleSheet()
	{
		$hojas = '';
		foreach(self::$css AS $item){
			$hojas .= "\t\t".'<link rel="stylesheet" href="'.$item.'"/>' . "\n";
		}
		return $hojas;
		
	}

	public static function getJavaScript()
	{
		$script = '';
		foreach(self::$js AS $item){
			$script .= "\t\t".'<script type="text/javascript" src="'.$item.'"></script>' . "\n";
		}
		return $script;
		
	}
}