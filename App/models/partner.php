<?php namespace App\Models;

use Core\Database,
    PDO,
    \stdClass;

defined("BASEPATH") or die("ACCESS DENIED");

class partner {

    private $db;

    function __construct()
    {
        $this->db = new Database();

    }

    function registerPartner($data){
        if( !is_array($data) ) {
            return null;
        }

        $this->db->insert('partner', $data);
        $result = $this->db->id() ? $this->db->id() : null;
        return $result;
    }
    
    function updatePartner($data, $id){
        if( !is_array($data) ) {
            return null;
        }

        $update = $this->db->update('partner', $data, ["id" => $id]);
        $result = $update->rowCount() >= 0 ? true : false;
        return $result;
    }

    function deletePartner($id){
        $delete = $this->db->delete('partner', ["id" => $id]);
        return $delete->rowCount() > 0 ? true : false;
    }

    function find($id = null){
        if( is_null($id) ){
            return $this->db->select('partner', "*");
        } else {
            return $this->db->select('partner', '*', [
                "id" => $id
            ]);
        }
    }
}