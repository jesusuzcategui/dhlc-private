<?php namespace App\Models;

use Core\Database,
    PDO;

defined("BASEPATH") or die("ACCESS DENIED");

class auditoria 
{
    private $dbo;

    function __construct()
    {
        $this->db = new Database;
    }

    function getDataVentas()
    {
        $sqlPagadas = "select state.descripcion as labels, count(targ.id) as cantidad from estado_targ as state left join targetas as targ on targ.estado_id = state.id group by state.id";
        
        $res1 = $this->db->query($sqlPagadas) ->fetchAll(PDO::FETCH_ASSOC);

        return $res1;
    }
}