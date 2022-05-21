<?php namespace App\Controllers;

defined("BASEPATH") or die("ACCESS DENIED");

use Core\Controller,
    Core\Model,
    App\helpers\Ajax;

class auditoria extends Controller
{
    private $modAuditoria;

    function __construct()
    {
        $this->modAuditoria = Model::loadModel('auditoria');
    }

    function ajax($act=null)
    {

        if( $act != null && Ajax::isAjax() ){
            switch($act){
                case 'tarjetas':
                    $result = $this->modAuditoria->getDataVentas();
                    print_r(json_encode($result));
                break;
            }
        }

    }
}