<?php


namespace App\helpers;

defined("BASEPATH") or die("ACCESS DENIED");

class flow
{
    private $instance;
    private $config;

    function __construct()
    {
        $path = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'librerias' . DIRECTORY_SEPARATOR . 'flow-client-php' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'FlowApi.class.php';

        include $path;

        $this->instance = new \FlowApi();
        $this->config = new \Config();
    }

    function getInstance(){
        return $this->instance;
    }

    function getConfig(){
        return $this->config;
    }

}