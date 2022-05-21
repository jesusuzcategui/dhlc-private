<?php namespace Core;

defined("BASEPATH") or die("Access denied");
USE \App;

class Helpers 
{
	public static $_helper;

	const GHELPERS_SPACE = "\App\helpers\\";

	const GHELPERS_PATH = "../App/helpers/";

	public static function loadHelper($helper)
	{
		self::$_helper = $helper;

		if( !is_file( self::GHELPERS_PATH . self::$_helper . ".php" ) ):
			throw new \Exception("The helper {self::$_helper} does exists or having erros", 1);
		else:
			$helper_class = self::GHELPERS_SPACE.self::$_helper;
			require_once(  self::GHELPERS_PATH . self::$_helper . ".php" );
			self::$_helper = new $helper_class;
			return  self::$_helper;
		endif;


	}
}