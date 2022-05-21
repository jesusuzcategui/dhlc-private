<?php namespace Core;

defined("BASEPATH") or die("Access denied");
USE \App;

class Model 
{
	public static $_model;

	const GMODELS_SPACE = "\App\Models\\";

	const MODELS_PATH = "../App/models/";

	public function __construct()
	{

	}

	public static function loadModel($model)
	{
		self::$_model = $model;

		if( !is_file( self::MODELS_PATH . self::$_model . ".php" ) ):
			throw new \Exception("The model {self::$_model} does exists or having erros", 1);
		else:
			$model_class = self::GMODELS_SPACE.self::$_model;
			include(  self::MODELS_PATH . self::$_model . ".php" );
			self::$_model = new $model_class;
			return  self::$_model;
		endif;


	}
}