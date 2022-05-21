<?php namespace App\Models;

use Core\Database,
    PDO;

defined("BASEPATH") or die("ACCESS DENIED");

class selects {

    private $db;

    function __construct()
    {
        $this->db = new Database();
    }

    function selectper($variable){
        $rol=$_SESSION['rol'];
        $per="select p.permiso FROM rol_per as rp inner join roles as r ON rp.roll_id=r.id INNER JOIN permisos as p on per_id=p.id where r.rol='".$rol."' and p.permiso=".$variable; 
        $permisos = $this->db->query($per)->fetchAll(PDO::FETCH_ASSOC);
        return (count($permisos) > 0) ? true : false;
       // return true;
    }


}