<?php
/**
 * Clase para Configurar el cliente
 * @Filename: Config.class.php
 * @version: 2.0
 * @Author: flow.cl
 * @Email: csepulveda@tuxpan.com
 * @Date: 28-04-2017 11:32
 * @Last Modified by: Carlos Sepulveda
 * @Last Modified time: 28-04-2017 11:32
 */
 
 class Config {
     
    const MODE = true;
 	
	function getNormal($name) {
        $COMMERCE_CONFIG = array(
            //"APIKEY" => "25F2D6DB-34B6-4E85-97AC-765321CL169D", // Registre aquí su apiKey
            "APIKEY" => "1F43847A-1480-4E5F-9F7C-3C2LDBED6134",
            "SECRETKEY" => "9a88028822b8405891437c22606d76dfa6f5a25c",
            //"SECRETKEY" => "dbf0673b06cc19a6a118a35ec5dc7d04a6cdd838", // Registre aquí su secretKey
            "APIURL" => "https://www.flow.cl/api", // Producción EndPoint o Sandbox EndPoint
            "BASEURL" => "https://https://tarjetalocutorios.com/flow", //Registre aquí la URL base en su página donde instalará el cliente
            "BASEURLVUE" => "https://tarjetalocutorios.com/#/"
        );
        
		if(!isset($COMMERCE_CONFIG[$name])) {
			throw new Exception("The configuration element thas not exist" . $name, 1);
		}
		return $COMMERCE_CONFIG[$name];
	}

     static function get($name) {
         
        if( self::MODE ){
            $COMMERCE_CONFIG = array(
                "APIKEY" => "1F43847A-1480-4E5F-9F7C-3C2LDBED6134",
                "SECRETKEY" => "9a88028822b8405891437c22606d76dfa6f5a25c",
                "APIURL" => "https://www.flow.cl/api",
                "BASEURL" => "https://https://tarjetalocutorios.com/flow",
                "BASEURLVUE" => "https://tarjetalocutorios.com/#/"
            );
        } else {
            $COMMERCE_CONFIG = array(
                "APIKEY" => "25F2D6DB-34B6-4E85-97AC-765321CL169D",
                "SECRETKEY" => "dbf0673b06cc19a6a118a35ec5dc7d04a6cdd838",
                "APIURL" => "https://sandbox.flow.cl/api",
                "BASEURL" => "https://https://tarjetalocutorios.com/flow",
                "BASEURLVUE" => "https://tarjetalocutorios.com/#/"
            );
        }

         if(!isset($COMMERCE_CONFIG[$name])) {
             throw new Exception("The configuration element thas not exist" . $name, 1);
         }
         return $COMMERCE_CONFIG[$name];
     }
 }
