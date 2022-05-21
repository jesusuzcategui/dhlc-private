<?php namespace App\helpers;

defined("BASEPATH") or die("ACCESS DENIED");

class FlowReport {
    static function templateFlowEmail($order, $tarjeta, $precio, $fecha, $toFile=false){
        $pathTemplate = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'flowOrder.php';
        if(is_file($pathTemplate)){
            ob_start();
            require $pathTemplate;
            $html = ob_get_clean();
            return $html;
        }

        return 'Template no cargado';
    }

    static function templateFreeEmail($order, $tarjeta, $precio, $fecha, $toFile=false){
        $pathTemplate = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'freeOrder.php';
        if(is_file($pathTemplate)){
            ob_start();
            require $pathTemplate;
            $html = ob_get_clean();
            return $html;
        }

        return 'Template no cargado';
    }
}