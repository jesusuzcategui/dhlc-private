<?php 

namespace App\Controllers;

use Core\Controller;
use Core\Model;
use Core\View;

use \stdClass;

defined("BASEPATH") or die("ACCESS DENIED");

class partner extends Controller
{
    private $model;

    public function __construct(){
        $this->model = Model::loadModel('partner');
    }

    public function index(){
        View::render(__CLASS__, 'partner', 'Partner');
    }

    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function store(){
        try {
            $data = [
                "nombre" => $_POST['nombre'],
                "serial" => $this->generateRandomString(6),
                "comentario" => $_POST['comentario']
            ];

            $result = $this->model->registerPartner($data);

            if( is_null($result) ){
                http_response_code(400);
                echo json_encode(["error" => "Record failed"]);
                return false;
            }

            echo json_encode(["error" => null]);

        } catch(\Exception $e){
            echo json_encode(["error" => json_encode($e)]);
        }
    }

    public function delete(){
        try {
            $result = $this->model->deletePartner(intval($_GET['id']));
            if( !$result ){
                http_response_code(400);
                echo json_encode(["error" => "Record failed"]);
                return false;
            }

            echo json_encode(["error" => null]);
        } catch(\Exception $e){
            echo json_encode(["error" => json_encode($e)]);
        }
    }
    
    public function update(){
        try {
            $data = [
                "nombre" => $_POST['nombre'],
                "estatus" => intval($_POST['estatus']),
                "comentario" => $_POST['comentario'],
                "bitly" => $_POST['bitly']
            ];

            $result = $this->model->updatePartner($data, $_GET['id']);

            if( !$result ){
                http_response_code(400);
                echo json_encode(["error" => "Record failed"]);
                return false;
            }

            echo json_encode(["error" => null]);

        } catch(\Exception $e){
            echo json_encode(["error" => json_encode($e)]);
        }
    }

    public function getPartners(){
        try {
            if( empty($_GET["id"]) ){
                $data = $this->model->find();
            } else {
                $data = $this->model->find($_GET["id"]);
            }
    
            echo json_encode($data);
        } catch(\Exception $e){
            echo json_encode(["error" => json_encode($e)]);
        }
    }
    
    public function getSales(){
        try {
            if( !empty($_GET["id"]) ){
                $data = $this->model->getSales($_GET["id"]);
            }
    
            echo json_encode($data);
        } catch(\Exception $e){
            echo json_encode(["error" => json_encode($e)]);
        }
    }
}