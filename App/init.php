<?php require_once("../defines.php");

spl_autoload_register( function($class){
	
	
	$filename = BASEPATH . SPR . str_replace('\\', SPR, $class) . '.php';
	
	if( is_file($filename) ){
		
		require_once($filename);

		
	}
	
	
} );