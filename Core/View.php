<?php namespace Core;
defined("BASEPATH") or die("Access denied");
USE Core\Assets;
USE Core\TinyMinify;

class View
{
	protected static $HtmlMinify;

    /**
	* @var
	*/
	protected static $data = [];

	/**
	* @var
	*/
	const VIEWS_PATH = "../App/views/";

	/**
	* @var
	*/
	const VIEWS_REPORT_PATH = "../App/views/reports/";

	/**
	* @var
	*/
	const INC_PATH = "../App/views/inc/";

	/**
	* @var
	*/
	const EXTENSION_TEMPLATES = "php";

	/**
	* @method
	*/
	public static function render($controller, $template, $title='')
	{
	    $ctrl = explode('\\', $controller)[2];
		if( !file_exists( self::VIEWS_PATH . $template . "." . self::EXTENSION_TEMPLATES ) ):

			throw new \Exception("Error: the file " . self::VIEWS_PATH . $template . "." . self::EXTENSION_TEMPLATES . " does exists", 1);

		endif;
		ob_start();
		if($title != ''):
			self::set('title_head', $title);
		endif;
		self::addCss();
		self::addJS();
		extract(self::$data);
		include( self::INC_PATH . "head.php" );
		include( self::VIEWS_PATH . $template . "." . self::EXTENSION_TEMPLATES );
		echo "\t\t".'<script src="js/'.$ctrl.'/'.$ctrl.'.js"></script> <!--File js to controller '.$ctrl.'-->';
		if($ctrl == "dashboard"){
			echo '<script src="/js/dashboard/banners.js"></script>';
			echo '<script src="/js/dashboard/ajustes.js"></script>';
			echo '<script src="/js/dashboard/clients.js"></script>';
		}
		include( self::INC_PATH . "foot.php" );
		$str = ob_get_contents();
		ob_end_clean();
		//Imprimi HTML minificado
		echo TinyMinify::html($str);

		return new self;

	}

	public static function set($name, $value)
	{
		self::$data[$name] = $value;
	}

	public static function view404()
	{
		self::addCss();
		self::addJS();
		self::set('title_head', 'Página no encontrada');
		extract(self::$data);
		include( self::INC_PATH . "head.php" );
		include( self::VIEWS_PATH . 'error/404.php' );
		include( self::INC_PATH . "foot.php" );
	}

	public static function viewError($error)
	{
		self::addCss();
		self::addJS();
		self::set('title_head', 'Página no encontrada');
		extract(self::$data);
		include( self::INC_PATH . "head.php" );
		include( self::VIEWS_PATH . 'error/'.$error.'.php' );
		include( self::INC_PATH . "foot.php" );
	}

	public static function addCss(){
		$css = new Assets;
		$css = $css::getStyleSheet();
		self::set("css", $css);
	}

	public static function addJS(){
		$js = new Assets;
		$js = $js::getJavaScript();
		self::set("js", $js);
	}

	public static function addNewJs($path)
	{
		$newJs = new Assets;
		return $newJs::setJavaScript($path);
	}
}
