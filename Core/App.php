<?php namespace Core; //Uso de namespace Core
defined("BASEPATH") or die("Access denied"); //Verificación de constante para la protección del proyecto.

use \App\Helpers; //Usar clase Helper.
use Core\View;

/**
 * @package Sarec
 * @subpackage Core
 * Clase principal que gestiona el mapeo de la url y ejecuta el controlador, método y parámetros.
 */

class App
{
	/**
	* Propiedades.
	*/
	/**
	* @var _controller
	*/
	private $_controller;

	/**
	* @var _method
	*/
	private $_method;

	/**
	* @var _params
	*/
	private $_params = [];

	/**
	* @var
	*/
	const GCONTROLLERS_SPACE = "\App\Controllers\\";

	/**
	* @var
	*/
	const CONTROLLERS_PATH = "../App/controllers/";

	/**
	* @method __contruct
	*/
	public function __construct()
	{
		//Mostrar errores php.
		error_reporting(E_ALL);
		ini_set("display_errors", 1);

	}

	public function init()
	{

				//Comenzamos la session.
				session_start();
				//Creamos una variable global con todas las variables de configuracion.
				$GLOBALS['site'] = (object) self::getConfig();

				$url = $this->parseUrl(); //Ejecutamos el método para parsear la URL

				$control = isset($url[0]) ? $url[0] : 'home'; //Indicamos el nombre de un controlador por defecto si no existe alguno en la url.

				$task    = isset($url[1]) ? $url[1] : 'index'; //Indicamos el nombre de un método por defecto si no existe alguno en la url.

				if( file_exists( self::CONTROLLERS_PATH.$control.".php" ) ): //Verificamos de que, exista el archivo del controlador.

					$this->_controller = $control; //Guardamos el nombre de controlador en la propiedad _controller

					include self::CONTROLLERS_PATH.$control.".php"; //Incluimos el archivo del controlador.

					unset($url[0]);

					//Creamos instancia del controlador.
					$fullClass = self::GCONTROLLERS_SPACE.$this->_controller;

					$this->_controller = new $fullClass;

					$this->_method = $task;

					if( method_exists($this->_controller, $this->_method) ):
						unset($url[1]);
						$this->_params = isset($url) ? array_values($url) : [];
					else:
						header('Location: '.$GLOBALS['site']->projectBase.'error/withoutaccess');
						exit;
					endif;

				endif;
	}

	/**
	* @method parseUrl
	*/
	public function parseUrl()
	{
		if(isset($_GET["url"])):
			return explode("/", filter_var(rtrim($_GET["url"], "/"), FILTER_SANITIZE_URL));
		endif;
	}

	/**
	* @method render
	*/
	public function render()
	{
		if(isset($this->_controller)):
			call_user_func_array([$this->_controller, $this->_method], $this->_params);
		else:
			header('Location: '.$GLOBALS['site']->projectBase.'error/withoutaccess');
		endif;
	}

	/**
	* @method getConfig
	*/
	public static function getConfig()
	{
		return parse_ini_file(JPATH . SPR.'config'.SPR.'config.ini');
	}

	/**
	* @method getController
	*/
	public function getController()
	{
		return $this->_controller;
	}

	/**
	* @method getControllerName
	*/
	public function getControllerName()
	{
		$url = $this->parseUrl(); //Ejecutamos el método para parsear la URL

		$control = isset($url[0]) ? $url[0] : 'home'; //Indicamos el nombre de un controlador por defecto si no existe alguno en la url.

		return $control;
	}

	/**
	* @method getMethod
	*/
	public function getMethod()
	{
		return $this->_method;
	}

	/**
	* @method getParams
	*/
	public function getParams()
	{
		return $this->_params;
	}

}
