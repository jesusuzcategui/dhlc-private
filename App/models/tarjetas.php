<?php namespace App\Models;

use Core\Database,
    PDO;

defined("BASEPATH") or die("ACCESS DENIED");

class tarjetas {

    private $db;

    function __construct()
    {
        $this->db = new Database();

    }
	
	function getPines($numero=""){
		
		$pin = trim($numero);
		
		if($pin == ""){
			$sql = "SELECT pin FROM targetas AS tar WHERE estatus_id = 1";
		} else {
			$sql = "SELECT pin FROM targetas AS tar WHERE tar.pin LIKE '%".$pin."%' and estatus_id = 1";
		}
		
		$pines = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
		return $pines;
	}

    function dropMultipleCard($cards)
    {
      if( !is_array($cards) ){
        return false;
      }

      if( count($cards) > 0 ){

        $resp = 0;

        foreach($cards as $card):
          $eliminado = $this->db->delete('targetas', ["id" => $card]);
          if( $eliminado->rowCount() > 0 ){
            $resp = $resp+1;
          }
        endforeach;

        return $resp;

      } else {
        return false;
      }

    }

    function addMultipleCard($arg){
        $insert = array();
        for($i=0; $i<count($arg); $i++){
            $monto =$arg[$i][2];
            $data  =explode(" ", $monto);
            if(isset($data[0]) && isset($data[1])):

                $valid = $this->consultping($arg[$i][1]);

                if($valid === true){

                    $precio = $this->consultprecio($data[1]);

                    $idPrecio = intval($precio[0]['id']);

                    $send = array(
                        "cod_targ"   => $arg[$i][0],
                        "pin"        => $arg[$i][1],
                        "precio"     => $idPrecio,
                        "estado_id"  => 1,
                        "estatus_id" => 1,
                        "creacion"   => date("Y-m-d H:i:s",time()-3600)
                    );

                    $resp = $this->savetar($send);

                    if( is_integer($resp) ){
                        if($resp > 0){
                            $resultado = 1;
                        } else {
                            $resultado = 2;
                        }
                    } else {
                        $resultado = 3;
                    }

                } else {
                    $resultado = 4;
                }

            else:
                $resultado = 5;
            endif;

            array_push($insert, $resultado);

        }

        return $insert;

    }

    function consultping($ping){

        $sql="select count(tar.pin) as cantidad from targetas as tar where tar.estatus_id=1 and tar.pin='{$ping}'";

        $ping = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        if($ping[0]['cantidad'] > 0){
            return false;
        } else {
            return true;
        }

    }

    function consultprecio($precio=null){

        $sql = "select id from monto where monto = '{$precio}' AND estatus_id !=2";

    $estado = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    return $estado;
    }


    function gettars($id=null){
        if($id!=null)
        {
            $sql = "select tar.id,tar.cod_targ,tar.pin,tar.creacion,tar.estado_id as estado, tar.precio from targetas  as tar inner join estado_targ as estar on tar.estado_id=estar.id inner join estatus as es on tar.estatus_id=es.id where es.id !=2 and tar.id=".$id;
        }else{
            $sql = "select tar.id,tar.cod_targ,tar.pin,tar.creacion,estar.estado, mt.monto as precio from targetas  as tar inner join estado_targ as estar on tar.estado_id=estar.id inner join estatus as es on tar.estatus_id=es.id inner join monto as mt on tar.precio=mt.id  where es.id !=2";
        }

        $usuarios = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		return $usuarios;
    }

    function getCardsForDataTable($keyWord="", $perPage=10, $columnIndex="id", $columnSort="DESC", $row=null, $filterByPrice="", $filterByState="")
    {

      if( $keyWord == "" ):
        $filterQ = "";
      else:
        $filterQ = " and tar.pin LIKE '%".$keyWord."%' or tar.cod_targ LIKE '%".$keyWord."%'";
      endif;

      if( $perPage == "-1" ):
        $limit = "";
      else:
        $limit = " LIMIT " . $row . ", " . $perPage;
      endif;

      if( $filterByPrice == "" ):
        $filterPrice = "";
      else:
        $filterPrice = " and tar.precio = '".intval($filterByPrice)."'";
      endif;

      if( $filterByState == "" ):
        $filterState = "";
      else:
        $filterState = " and tar.estado_id = '".intval($filterByState)."'";
      endif;

      //Total de registros sin filtro.
      $q = "select count(tar.id) as allcount from targetas  as tar inner join estado_targ as estar on tar.estado_id=estar.id inner join estatus as es on tar.estatus_id=es.id inner join monto as mt on tar.precio=mt.id  where es.id !=2";
      $cantTotalSF = $this->db->query($q)->fetchAll(PDO::FETCH_ASSOC);
      $cantTotalSF = $cantTotalSF[0]['allcount'];

      //Total de registros con filtro.
      $q = "select count(tar.id) as allcount from targetas  as tar inner join estado_targ as estar on tar.estado_id=estar.id inner join estatus as es on tar.estatus_id=es.id inner join monto as mt on tar.precio=mt.id  where es.id !=2 " . $filterQ . $filterPrice . $filterState;

      $cantTotalCF = $this->db->query($q)->fetchAll(PDO::FETCH_ASSOC);
      $cantTotalCF = $cantTotalCF[0]['allcount'];

      //Obtención de registros.
      $q = "select tar.id,tar.cod_targ,tar.pin,tar.creacion,estar.estado, mt.monto as precio from targetas  as tar inner join estado_targ as estar on tar.estado_id=estar.id inner join estatus as es on tar.estatus_id=es.id inner join monto as mt on tar.precio=mt.id  where es.id !=2 " . $filterQ . $filterPrice . $filterState . " ORDER BY " .$columnIndex . " " . $columnSort . $limit;

      $tarjetasR = $this->db->query($q)->fetchAll(PDO::FETCH_ASSOC);

      return array(
        "total"   => $cantTotalSF,
        "totalD"  => $cantTotalCF,
        "data"    => $tarjetasR
    );

    }



    function getestado($id=null){

            $sql = "select id, estado as descripcion, estatus_id from estado_targ where estatus_id !=2";

        $estado = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        return $estado;
    }

    function getprecio($id=null){

        $sql = "select id, monto as descripcion, estatus_id from monto where estatus_id !=2";

    $estado = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    return $estado;
    }


    function savetar($data){
		$insert = $this->db->insert('targetas', $data);
        return $this->db->id() ? intval($this->db->id()) : null;
       // return $data;
    }

    function actualizartar($data,$id){
        $update = $this->db->update('targetas', $data, [
            "id" => $id
          ]);
        //return $this->db->id() ? $this->db->id() : null;
        return $update->rowCount();
    }

    function getUserByEmail($email=null)
    {
        if($email == null){
            return null;
        }else{
            $usuario = $this->db->select('usuarios', '*', [
                'email' => $email
            ]);

           if (count($usuario) > 0){
               return $usuario;
           }else{
               return null;
           }
        }


    }

    function getCardPerPage($id=null, $limit=1000){
        if($id!=null)
        {
            $sql = "select tar.id,tar.cod_targ,tar.pin,tar.creacion,tar.estado_id as estado, tar.precio from targetas  as tar inner join estado_targ as estar on tar.estado_id=estar.id inner join estatus as es on tar.estatus_id=es.id where es.id !=2 and tar.id=".$id." limit ".$limit;
        }else{
            $sql = "select tar.id,tar.cod_targ,tar.pin,tar.creacion,estar.estado, mt.monto as precio from targetas  as tar inner join estado_targ as estar on tar.estado_id=estar.id inner join estatus as es on tar.estatus_id=es.id inner join monto as mt on tar.precio=mt.id  where es.id !=2 limit ".$limit;
        }

        $usuarios = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		return $usuarios;
    }
    
    function updateMasiveCard($cards, $estate){
        if( !is_array($cards) ){
            return false;
        }

        if( count($cards) > 0 ){

            $resp = 0;

            foreach($cards as $card):
                $eliminado = $this->db->update('targetas', ["estado_id" => $estate], ["id" => $card]);
                if( $eliminado->rowCount() > 0 ){
                $resp = $resp+1;
                }
            endforeach;

            return $resp;

        } else {
            return false;
        }
    }


    function verifyUser($user=array()){

        if(!is_array($user)) {
            return null;
        }
        $email=$user['email'];
        $contra=$user['contra'];

        $sql = "select email, rl.rol as rol_id, estatusrolid from  usuarios as us inner join roles rl on us.rol_id=rl.id where estatusrolid !=2 and us.email='".$email."' and us.contra='".$contra."'";

        $usuario = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION['rol']=$usuario[0]['rol_id'];

        $per="SELECT p.permiso FROM rol_per as rp INNER JOIN roles as r ON rp.roll_id=r.id INNER JOIN permisos as p on per_id=p.id where r.rol='administrador'";

        $permisos = $this->db->query($per)->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION['permisos']=$permisos;

        //return $usuarios;

        /*$usuario = $this->db->select('usuarios', '*', [
            'AND' => [
                'email' => $user['email'],
                'contra' => $user['contra']
            ]
        ]);
       */
        return (count($usuario) > 0) ? true : false;
    }
    
    function getPinById($idrecord){
        $query = 'SELECT pin FROM targetas WHERE id = "'.$idrecord.'"';

        $result = $this->db->query($query)->fetch(PDO::FETCH_COLUMN);

        return $result;
    }
    
    function getBasicPinById($idrecord){
        $query = "SELECT CONCAT('CLP ', m.monto) as precio, t.pin FROM targetas as t left join monto as m on m.id = t.precio WHERE t.id = '".$idrecord."'";

        $result = $this->db->query($query)->fetch(PDO::FETCH_OBJ);
        
        var_dump($result);

        return $result;
    }

}
