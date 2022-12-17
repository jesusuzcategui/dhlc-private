<?php namespace App\Models;

use Core\Database,
    PDO;

defined("BASEPATH") or die("ACCESS DENIED");

class montos {

    private $db;

    function __construct(){
        $this->db = new Database();
    }

    function loadPrice($id=null){
        if( is_null($id) )
        {
            return $this->db->select('monto', '*');
        } else {
            return $this->db->select('monto', '*', [
                'id' => $id
            ]);
        }
    }

    function uploadImage($id, $image_field, $link){
        return $this->db->update('monto', [
            $image_field => $link
        ], [
            "id" => $id
        ]);
    }

}