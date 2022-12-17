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

    function getSales($id=null){
        $query = "select vf.id, vf.correo, vf.correo_cliente, vf.cupon, vf.monto_venta, vf.cupon_porcentaje, us.email, vf.telefono, vf.inicio, vf.fin, tar.cod_targ,tar.pin, mn.monto as precio,vf.id_operacion,vf.fecha, es.id estado_id, es.estado, par.id as id_part, par.nombre as partner FROM ventas_frecuentes as vf inner join usuarios as us on id_usu=us.id inner join targetas as tar on id_targeta=tar.id inner join estado_targ as es on vf.estado=es.id inner join monto as mn on tar.precio=mn.id left join partner as par on par.serial = vf.partner where vf.id_estatus!=2 and par.id = '".$id."' order by vf.id desc";

        $ventasR = $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);

        return $ventasR;
    }
}