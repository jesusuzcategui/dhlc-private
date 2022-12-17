<?php 

namespace App\Controllers;

use Core\Controller;
use Core\Model;
use Core\View;

use \stdClass;

defined("BASEPATH") or die("ACCESS DENIED");

class cupones extends Controller
{
    private $model;

    public function __construct(){
        $this->model = Model::loadModel('cupones');
    }


    public function index(){
        View::render(__CLASS__, 'cupones', 'Cupones');
    }

    public function find(){
        if( empty($_GET['id']) ){
            $data = $this->model->find();
            return $this->response($data);
        }

        return $this->response( $this->model->find($_GET['id']) );
    }

    public function store(){
        $data = [
            "cupon" => $_POST['cupon'],
            "porcentaje" => floatval($_POST['porcentaje']),
            "comment" => $_POST['comentario']
        ];

        $result = $this->model->store($data);

        if(!$result){
            return $this->response([
                "error" => "record failed"
            ], 400);
        }

        return $this->response([
            "error" => null
        ]);
    }
    
    public function update(){
        $data = [
            "cupon" => $_POST['cupon'],
            "porcentaje" => floatval($_POST['porcentaje']),
            "comment" => $_POST['comentario'],
            "estatus" => intval($_POST['estatus'])
        ];

        $result = $this->model->update($data, $_GET['id']);

        if(!$result){
            return $this->response([
                "error" => "record failed"
            ], 400);
        }

        return $this->response([
            "error" => null
        ]);
    }

    public function delete(){
        if(empty($_GET['id'])){
            return $this->response(["error"  => "id empty"], 400);
        }

        $result = $this->model->delete($_GET['id']);

        if(!$result){
            return $this->response(["error" => "record no delete"], 400);
        }

        return $this->response([
            "error" => null
        ]);
    }


}