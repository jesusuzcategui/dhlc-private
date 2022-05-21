<?php namespace App\Models;

use Core\Database,
    PDO,
    \stdClass;

defined("BASEPATH") or die("ACCESS DENIED");

class ventas {

    private $db;

    function __construct()
    {
        $this->db = new Database();

    }
	
	function getTotalByFilter($ini=null, $fin=null){
		
		if( isset($ini) && !is_null($ini) && !empty($ini) ){
			$queryFecha = " AND (DATE(vf.inicio) BETWEEN '".$ini."' AND '".$fin."')";
		} else {
			$queryFecha = "";
		}
		
		$queryMain  = "SELECT";
		$queryMain .= "( SELECT COUNT(vf.id) FROM ventas_frecuentes AS vf LEFT JOIN targetas AS tar ON tar.id = vf.id_targeta LEFT JOIN monto AS pre ON pre.id = tar.precio WHERE vf.estado=3 AND tar.estado_id=3 AND (tar.precio = 1 OR tar.precio = 2 OR tar.precio = 3 OR tar.precio = 6 OR tar.precio = 7) ".$queryFecha.") AS ventas_aprovadas,";
		$queryMain .= "( SELECT COUNT(vf.id) FROM ventas_frecuentes AS vf LEFT JOIN targetas AS tar ON tar.id = vf.id_targeta LEFT JOIN monto AS pre ON pre.id = tar.precio WHERE vf.estado=5 AND (tar.precio = 1 OR tar.precio = 2 OR tar.precio = 3) ".$queryFecha.") AS ventas_eliminadas,";
		$queryMain .= "( SELECT SUM(pre.monto) FROM ventas_frecuentes AS vf LEFT JOIN targetas AS tar ON tar.id = vf.id_targeta LEFT JOIN monto AS pre ON pre.id = tar.precio WHERE vf.estado=3 AND tar.estado_id=3  ".$queryFecha." ) AS ventas_total_dinero,";
		$queryMain .= "( SELECT SUM(pre.monto) FROM ventas_frecuentes AS vf LEFT JOIN targetas AS tar ON tar.id = vf.id_targeta LEFT JOIN monto AS pre ON pre.id = tar.precio WHERE vf.estado=3 AND tar.estado_id=3 AND tar.precio = 1 ".$queryFecha.") AS ventas_total_mil,";
		$queryMain .= "( SELECT SUM(pre.monto) FROM ventas_frecuentes AS vf LEFT JOIN targetas AS tar ON tar.id = vf.id_targeta LEFT JOIN monto AS pre ON pre.id = tar.precio WHERE vf.estado=3 AND tar.estado_id=3 AND tar.precio = 2 ".$queryFecha.") AS ventas_total_dosmil,";
		$queryMain .= "( SELECT SUM(pre.monto) FROM ventas_frecuentes AS vf LEFT JOIN targetas AS tar ON tar.id = vf.id_targeta LEFT JOIN monto AS pre ON pre.id = tar.precio WHERE vf.estado=3 AND tar.estado_id=3 AND tar.precio = 3 ".$queryFecha.") AS ventas_total_cincomil,";
		$queryMain .= "( SELECT SUM(pre.monto) FROM ventas_frecuentes AS vf LEFT JOIN targetas AS tar ON tar.id = vf.id_targeta LEFT JOIN monto AS pre ON pre.id = tar.precio WHERE vf.estado=3 AND tar.estado_id=3 AND tar.precio = 6 ".$queryFecha.") AS ventas_total_diezmil,";
		$queryMain .= "( SELECT COUNT(vf.id) FROM ventas_frecuentes AS vf LEFT JOIN targetas AS tar ON tar.id = vf.id_targeta LEFT JOIN monto AS pre ON pre.id = tar.precio WHERE vf.estado=3 AND tar.estado_id=3 AND tar.precio = 1 ".$queryFecha.") AS cant_tar_mil,";
		$queryMain .= "( SELECT COUNT(vf.id) FROM ventas_frecuentes AS vf LEFT JOIN targetas AS tar ON tar.id = vf.id_targeta LEFT JOIN monto AS pre ON pre.id = tar.precio WHERE vf.estado=3 AND tar.estado_id=3 AND tar.precio = 2 ".$queryFecha.") AS cant_tar_dosmil,";
		$queryMain .= "( SELECT COUNT(vf.id) FROM ventas_frecuentes AS vf LEFT JOIN targetas AS tar ON tar.id = vf.id_targeta LEFT JOIN monto AS pre ON pre.id = tar.precio WHERE vf.estado=3 AND tar.estado_id=3 AND tar.precio = 3 ".$queryFecha.") AS cant_tar_cincomil,";
		$queryMain .= "( SELECT COUNT(vf.id) FROM ventas_frecuentes AS vf LEFT JOIN targetas AS tar ON tar.id = vf.id_targeta LEFT JOIN monto AS pre ON pre.id = tar.precio WHERE vf.estado=3 AND tar.estado_id=3 AND tar.precio = 6 ".$queryFecha.") AS cant_tar_diezmil";
		
		$resultado = $this->db->query($queryMain)->fetchAll(PDO::FETCH_ASSOC);	
		
		return $resultado;
		
	}

    function updateState($data, $id)
    {
      #data tarjeta:
      $tarjeta = $this->db->select('ventas_frecuentes', 'id_targeta', [
        "id" => $id
      ]);

      #actualizamos la venta
      $update = $this->db->update('ventas_frecuentes', $data, [
        "id" => intval($id)
      ]);

      #Verificamos la actualización de la venta.
      if($update->rowCount() >= 0){
        #Actualizamos la tarjeta
        $updateCard = $this->db->update('targetas', [
          "estado_id" => intval($data['estado'])
        ], [
          "id"        => intval( $tarjeta[0] )
        ]);
        #Verificamos la actualización
        if( $updateCard->rowCount() >= 0 )
        {
          return true;
        } else {
          return false;
        }
      } else {
        return false;
      }
    }


    function filterVentas($query=null, $state=null, $ini=null, $fin=null, $precio=null)
    {
      if(isset($query) && $query != "" && !is_null($query) && !empty($query)){
        $sqlQuery = " and (vf.correo_cliente like '%".$query."%' or vf.telefono like '%".$query."%' or vf.id_operacion like '%".$query."%') ";
      } else {
        $sqlQuery = "";
      }

      if(isset($state) && $state != "" && !is_null($state)  && !empty($state)){
        $sqlState = " and vf.estado = '".$state."' ";
      } else {
        $sqlState = "";
      }

      if( (isset($ini) && $ini != "" && !is_null($ini) && !empty($ini)) && (isset($fin) && $fin != "" && !is_null($fin) && !empty($fin)) ){
        $sqlDate = " and  (DATE(vf.inicio) BETWEEN '".$ini."' AND '".$fin."') ";
      } else {
        $sqlDate = "";
      }

      if(isset($precio) && $precio != "" && !is_null($precio) && !empty($precio)){
        $sqlPrice = " and mn.id = '".$precio."' ";
      } else {
        $sqlPrice = "";
      }

      //Total de registros sin filtro.
      $q = "select count(vf.id) as allcount FROM ventas_frecuentes as vf inner join usuarios as us on id_usu=us.id inner join targetas as tar on id_targeta=tar.id inner join estado_targ as es on vf.estado=es.id inner join monto as mn on tar.precio=mn.id where vf.id_estatus!=2";
      $cantTotalSF = $this->db->query($q)->fetchAll(PDO::FETCH_ASSOC);
      $cantTotalSF = $cantTotalSF[0]['allcount'];

      //Total de registros con filtro.
      $q = "select count(vf.id) as allcount FROM ventas_frecuentes as vf inner join usuarios as us on id_usu=us.id inner join targetas as tar on id_targeta=tar.id inner join estado_targ as es on vf.estado=es.id inner join monto as mn on tar.precio=mn.id where vf.id_estatus!=2 " . $sqlQuery . $sqlState . $sqlPrice . $sqlDate;

      $cantTotalCF = $this->db->query($q)->fetchAll(PDO::FETCH_ASSOC);
      $cantTotalCF = $cantTotalCF[0]['allcount'];

      //Obtención de registros.

      $q = "select vf.id, vf.correo, vf.correo_cliente, us.email,vf.telefono, vf.inicio, vf.fin, tar.cod_targ,tar.pin, mn.monto as precio,vf.id_operacion,vf.fecha, es.id estado_id, es.estado FROM ventas_frecuentes as vf inner join usuarios as us on id_usu=us.id inner join targetas as tar on id_targeta=tar.id inner join estado_targ as es on vf.estado=es.id inner join monto as mn on tar.precio=mn.id where vf.id_estatus!=2 " . $sqlQuery . $sqlState . $sqlPrice . $sqlDate;

      $ventasR = $this->db->query($q)->fetchAll(PDO::FETCH_ASSOC);

      $result = new stdClass;

      $result->data          = $ventasR;
      $result->total         = intval($cantTotalSF);
      $result->totalF        = intval($cantTotalCF);
      $result->totalesVentas = $this->getTotalByFilter($ini, $fin);

      return $result;
    }

    function getSaleForDataTable($query="", $perPage=10, $columnIndex="vf.id", $columnSort="DESC", $row=null, $precio="", $state="", $ini="", $fin="")
    {
      if(isset($query) && $query != "" && !is_null($query) && !empty($query)){
        $sqlQuery = " and (vf.correo_cliente like '%".$query."%' or vf.telefono like '%".$query."%' or vf.id_operacion like '%".$query."%' or tar.pin like '%".$query."%') ";
      } else {
        $sqlQuery = "";
      }

      if(isset($state) && $state != "" && !is_null($state)  && !empty($state)){
        $sqlState = " and vf.estado = '".$state."' ";
      } else {
        $sqlState = "";
      }

      if( (isset($ini) && $ini != "" && !is_null($ini) && !empty($ini)) && (isset($fin) && $fin != "" && !is_null($fin) && !empty($fin)) ){
        $sqlDate = " and  (DATE(vf.inicio) BETWEEN '".$ini."' AND '".$fin."') ";
      } else {
        $sqlDate = "";
      }

      if(isset($precio) && $precio != "" && !is_null($precio) && !empty($precio)){
        $sqlPrice = " and mn.id = '".$precio."' ";
      } else {
        $sqlPrice = "";
      }

      if( $perPage == "-1" ):
        $limit = "";
      else:
        $limit = " LIMIT " . $row . ", " . $perPage;
      endif;

      //Total de registros sin filtro.
      $q = "select count(vf.id) as allcount FROM ventas_frecuentes as vf inner join usuarios as us on id_usu=us.id inner join targetas as tar on id_targeta=tar.id inner join estado_targ as es on vf.estado=es.id inner join monto as mn on tar.precio=mn.id where vf.id_estatus!=2";
      $cantTotalSF = $this->db->query($q)->fetchAll(PDO::FETCH_ASSOC);
      $cantTotalSF = $cantTotalSF[0]['allcount'];

      //Total de registros con filtro.
      $q = "select count(vf.id) as allcount FROM ventas_frecuentes as vf inner join usuarios as us on id_usu=us.id inner join targetas as tar on id_targeta=tar.id inner join estado_targ as es on vf.estado=es.id inner join monto as mn on tar.precio=mn.id where vf.id_estatus!=2 " . $sqlQuery . $sqlState . $sqlPrice . $sqlDate;

      $cantTotalCF = $this->db->query($q)->fetchAll(PDO::FETCH_ASSOC);
      $cantTotalCF = $cantTotalCF[0]['allcount'];

      //Obtención de registros.

      $q = "select vf.id, vf.correo, vf.correo_cliente, us.email,vf.telefono, vf.inicio, vf.fin, tar.cod_targ,tar.pin, mn.monto as precio,vf.id_operacion,vf.fecha, es.id estado_id, es.estado FROM ventas_frecuentes as vf inner join usuarios as us on id_usu=us.id inner join targetas as tar on id_targeta=tar.id inner join estado_targ as es on vf.estado=es.id inner join monto as mn on tar.precio=mn.id where vf.id_estatus!=2 " . $sqlQuery . $sqlState . $sqlPrice . $sqlDate . " ORDER BY " .$columnIndex . " " . $columnSort . $limit;

      $ventasR = $this->db->query($q)->fetchAll(PDO::FETCH_ASSOC);

      return array(
        "total"   => $cantTotalSF,
        "totalD"  => $cantTotalCF,
        "data"    => $ventasR
      );
    }


    function getvent($id=null){
        if($id!=null)
        {
            $sql = "select vf.id, vf.tipo_venta, vf.mensaje_webpay, vf.correo, vf.correo_cliente, us.email,vf.telefono, vf.inicio, vf.fin, tar.cod_targ,tar.pin, mn.monto as precio,vf.id_operacion,vf.fecha, es.id estado_id, es.estado FROM ventas_frecuentes as vf inner join usuarios as us on id_usu=us.id inner join targetas as tar on id_targeta=tar.id inner join estado_targ as es on vf.estado=es.id inner join monto as mn on tar.precio=mn.id where vf.id_estatus!=2 and vf.id = '".$id."'";
        }else{
            $sql = "select vf.id, vf.correo, vf.correo_cliente, us.email,vf.telefono, vf.inicio, vf.fin, tar.cod_targ,tar.pin, mn.monto as precio,vf.id_operacion,vf.fecha, es.id estado_id, es.estado FROM ventas_frecuentes as vf inner join usuarios as us on id_usu=us.id inner join targetas as tar on id_targeta=tar.id inner join estado_targ as es on vf.estado=es.id inner join monto as mn on tar.precio=mn.id where vf.id_estatus!=2";
        }

        $usuarios = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		return $usuarios;
    }

    function verifitarventa($pago,$id=null){
        if($id==null){
            $sql ="select tg.id, m.monto,tg.pin as targeta FROM targetas as tg inner join monto as m on tg.precio=m.id where estado_id='1' and tg.estatus_id!=2 and tg.precio=".$pago." LIMIT 1";
        }else{
            $sql ="select tg.pin as targeta FROM targetas as tg  where tg.id=".$id;
        }

        $venta = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		      return $venta;
    }

    function actualizartarjeta($targeta,$estadotargeta){

        $data1=array(
            "estado_id"=>intval($estadotargeta)
        );

        $update = $this->db->update('targetas', $data1, ["id" => intval($targeta)]);

        $respuesta = $update->rowCount();

        $return = (is_integer($respuesta) && $respuesta >= 0) ? true : false;

        return $return;

    }

    function actualizarventa($venta, $estadoventa,$tipo="N/A",$webpay="N/A", $fin=null){

        $update =  $this->db->update('ventas_frecuentes', [
            "estado" => $estadoventa,
            "tipo_venta" => $tipo,
            "mensaje_webpay" => $webpay,
            "fin"            => $fin
        ], [
            "id" => intval($venta)
        ]);

        $respuesta = $update->rowCount();

        $result = (is_integer($respuesta) && $respuesta > 0) ? true : false;

        return $result;
    }
	
	function getDataSales(){
		$sql = 'SELECT UPPER(vf.correo_cliente) AS email, vf.telefono, (
	SELECT COUNT(*) FROM ventas_frecuentes AS vff WHERE vff.correo_cliente = vf.correo_cliente
) AS cantidad, (
	SELECT vff.inicio FROM ventas_frecuentes AS vff WHERE vff.correo_cliente = vf.correo_cliente ORDER BY vff.id DESC LIMIT 1
) AS ultima_fecha
FROM ventas_frecuentes AS vf
WHERE vf.estado = 3
GROUP BY vf.correo_cliente
ORDER BY vf.correo_cliente';

        $estado = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        return $estado;
	}

    function getestado($id=null){

            $sql = "select id, estado as descripcion, estatus_id from estado_targ where estatus_id !=2";

        $estado = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        return $estado;
    }

    function savevent($data){
      $insert = $this->db->insert('ventas_frecuentes', $data);
      $data = $this->db->id() ? $this->db->id() : null;
      return $data;
    }
	
	function ventamanual($data){
		$response = array();
		$insert = $this->db->insert('ventas_frecuentes', $data);
		$response['error'] = $this->db->error();
		$response['id']    = $this->db->id() ? $this->db->id() : null;
		return $response;
	}

    function actualizartar($data,$id){
        $update = $this->db->update('targetas', $data, [
            "id" => $id
          ]);
        //return $this->db->id() ? $this->db->id() : null;
        return $update->rowCount();
    }




    function verifyEmail($email=null)
    {
        $sql = "select id from  usuarios where email='".$email."'";

        return $usuario = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    function calculateEarne($from, $to, $ammount){
      return [
        "from"    => $from,
        "to"      => $to,
        "ammount" => $ammount
      ];
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
    
    public function getOrderNumberById($recordId){
        $query = 'select id_operacion from ventas_frecuentes where id = "'.$recordId.'"';
        $result = $this->db->query($query)->fetch(PDO::FETCH_COLUMN);
        return $result;
    }
    
    public function getBasicOrder($recordId){
      $query = "select v.id_operacion, v.fin, v.correo_cliente from ventas_frecuentes as v where id = '".$recordId."'";
      
      $result = $this->db->query($query)->fetch(PDO::FETCH_OBJ);

      return $result;
    }

    public function getOrderInfo($param){
      $query = "select v.id_operacion, v.correo_cliente, t.pin, v.fin, v.mensaje_webpay from ventas_frecuentes as v left join targetas as t on t.id = v.id_targeta where v.id = '".$param."'";
      
      $result = $this->db->query($query)->fetch(PDO::FETCH_OBJ);

      return $result;
    }
    
    public function getFreecardd($correo, $telefono){
        $query = "select v.id_operacion from ventas_frecuentes as v left join targetas as tar on tar.id = v.id_targeta where LOWER(v.correo_cliente) = '".$correo."' and v.telefono = '".$telefono."' and tar.precio = 7";
        $result1 = $this->db->query($query)->fetch(PDO::FETCH_OBJ);
        
        if($result1 == false){
          return true;
        } else {
          return false;
        }
    }
    
    public function getClientsFromNotSales($init, $ended){
        $query = "SELECT DISTINCT LOWER(correo_cliente) correo, telefono from ventas_frecuentes where correo_cliente not in (select correo_cliente from ventas_frecuentes where DATE(inicio) BETWEEN '".$init."' AND '".$ended."')";
        
        $return = $this->db->query($query)->fetchAll(PDO::FETCH_OBJ);
        
        return $return;
    }

    public function getVentaFree($correo, $telefono){
      $query = "select tar.* from targetas as tar where tar.precio = 7 and tar.estado_id = 1 limit 1";
      $result1 = $this->db->query($query)->fetch(PDO::FETCH_OBJ);

      if( $result1 === false ){
        return ["data" => 1];
      }

      $orderId = strval(rand(100000, 999999999));

      $data = array(
        "id_targeta" => $result1->id,
        "id_estatus" => 1,
        "fecha" => date("Y-m-d H:i:s",time()-3600),
        "id_operacion" => $orderId,
        "id_usu" => 1,
        "correo" => "abonos@locutorios.cl",
        "correo_cliente" => $correo,
        "estado" => 3,
        "telefono" => $telefono,
        "tipo_venta" => "VENTA GRATUITA DE NAVIDAD",
        "mensaje_webpay" => "N/A",
        "inicio" => date("Y-m-d H:i:s",time()-3600),
      );

      $insert = $this->db->insert('ventas_frecuentes', $data);
      $result2 = $this->db->id() ? $this->db->id() : null;

      if( is_null($result2) === false ){
        $this->db->update('targetas', [
          "estado_id" => 3
        ], [
            "id" => intval($result1->id)
        ]);

        
        return ["data" => 2, "datos" => [
          "pin" => $result1,
          "order" => $orderId
        ]];
      } else {
        return ["data" => 3];
      }
    }

}
