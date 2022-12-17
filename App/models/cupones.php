<?php namespace App\Models;

use Core\Database,
    PDO;

defined("BASEPATH") or die("ACCESS DENIED");

class cupones {

    private $db;

    function __construct()
    {
        $this->db = new Database();

    }

    function verifyCoupon($cupon){
        return $this->db->has('cupones', [
            "cupon" => $cupon
        ]);
    }

    function find($id = null){
        if( is_null($id) ){
            return $this->db->select('cupones', "*");
        }

        return $this->db->select('cupones', "*", ["id" => $id]);
    }

    function store($data){
        if( !is_array($data) ){
            return false;
        }

        $response = $this->db->insert('cupones', $data);
        return $response->rowCount() > 0;
    }
    
    function update($data, $id){
        if( !is_array($data) ){
            return false;
        }

        if( empty($id) ){
            return false;
        }

        $response = $this->db->update('cupones', $data, ["id" => $id]);
        return $response->rowCount() > 0;
    }

    function delete($id){
        if( empty($id) ){
            return false;
        }

        $response = $this->db->delete('cupones', ["id" => $id]);

        return $response->rowCount() > 0;
    }
}