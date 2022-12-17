<?php 

namespace App\Controllers;

use Core\Controller;
use Core\Model;
use \stdClass;

defined("BASEPATH") or die("ACCESS DENIED");

class jsonsale extends Controller
{
    private $modelVentas;

    public function __construct(){
        $this->modelVentas = Model::loadModel('ventas');
    }

    public function getSales(){
        $sales = $this->modelVentas->getvent();
        echo json_encode($sales);        
    }
}