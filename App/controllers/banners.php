<?php namespace App\Controllers; //ee6d7cb4d452a291840473c1677e0779d03154206f79c386a48141ad43148b53

use Core\Controller;
use Core\Model;
use Core\Mail;
use Core\Config;
use App\helpers\Ajax;
use App\helpers\Functions;
use App\helpers\FlowReport;
use \Dompdf\Dompdf;
use \stdClass;

defined("BASEPATH") or die("ACCESS DENIED");

class banners extends Controller
{
    private $model;
    
    function __construct(){
        parent::__construct();
        $this->model = Model::loadModel('dashboard');
    }
    
    function getAviable(){
        $banners = $this->model->findAviableBanner();
        $result = array_map(function($e){
            $m = $e;
            $m["image_url"] = "https://dashboard.tarjetalocutorios.com/" . $e["image_url"];
            $m["image_movil"] = ($e["image_movil"]) ? "https://dashboard.tarjetalocutorios.com/" . $e["image_movil"] : null;
            return $m;
        }, $banners);
        echo json_encode($result);
    }
}