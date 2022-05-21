<?php

//Comenzamos la session.
//session_set_cookie_params(["samesite" => 'None']);
//ini_set('session.cookie_samesite', 'None');
//session_start();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

error_reporting(1);
require_once('../App/init.php');

date_default_timezone_set('America/Santiago');

require_once("../vendor/autoload.php");

spl_autoload_register( function($class){
	
	
	$filename = BASEPATH . SPR . str_replace('\\', SPR, $class) . '.php';
	
	if( is_file($filename) ){
		
		require_once($filename);

		
	}
	
	
} );

use \Core\Jdev,
	\Core\Config,
	\App\helpers\Functions;


if(!Functions::isLocal()){
	if(!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on")
	{
		header('Location: '.Config::AppUrl['web']);
		exit;
	}	
}

Functions::session();

$app = new Jdev;

$app->init();

$app->render();