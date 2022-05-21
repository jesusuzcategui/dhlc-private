<?php namespace App\Models;

use Core\Database,
    PDO;

defined("BASEPATH") or die("ACCESS DENIED");

class usuarios {

    private $db;

    function __construct()
    {
        $this->db = new Database();
       
    }

    function get($id=null)
    {
        if( $id==null ){
            return $this->db->select('usuarios', '*');
        } else {
            return $this->db->select('usuarios', '*', [
                'id' => $id
            ]);
        }
    }

    function getUsus($id=null){
        if($id!=null)
        {
            $sql = "select usu.id, usu.cedula,usu.telefono,usu.email,usu.rol_id as croll,pr.rol as roll from usuarios as usu inner join roles as pr on usu.rol_id=pr.id inner join estatus as e on usu.estatus_id=e.id where e.id !=2 and usu.id!=1 and usu.id=".$id;
        }else{
            $sql = "select usu.id, usu.cedula,usu.telefono,usu.email,usu.rol_id as croll,usu.contra,pr.rol as roll from usuarios as usu inner join roles as pr on usu.rol_id=pr.id inner join estatus as e on usu.estatus_id=e.id where  e.id !=2 and usu.id!=1"; 
        }
        
        $usuarios = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		return $usuarios;
    }

    
    
    function getRoll($id=null){
       
            $sql = "select id,rol as descripcion, estatusrolid from roles where estatusrolid !=2";
        
        $usuarios = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        
        return $usuarios;
    }

    function saveusu($data){
		$insert = $this->db->insert('usuarios', $data);
        return $this->db->id() ? $this->db->id() : null; 
       // return $data;
    }

    function actualizarusu($data,$id){
        $update = $this->db->update('usuarios', $data, [
            "id" => $id
          ]);
        //return $this->db->id() ? $this->db->id() : null; 
        return $update->rowCount();
    }

  


    function verifyEmail($email=null)
    {
        if($email == null){
            return null;
        }

        $usuario = $this->db->select('usuarios', '*', [
            'email' => $email
        ]);

        return (count($usuario) > 0) ? true : false;
    }


    function getDatoUsuario($field=null, $value=null)
    {
        if( !is_null($field) && !is_null($value) ):
            switch($field):
                case 'email':
                    $resp = $this->db->select('usuarios', 'email', [
                        "email" => $value
                    ]);
                    return $resp;
                break;
            endswitch;
        else:
            return null;
        endif;
    }

    function updatePassword($id=null, $contra=null)
    {

        if( !is_null($id) && !is_null($contra) ):
            $resp = $this->db->update('usuarios', [
                "contra" => $contra
            ], [
                "email" => $id
            ]);
            return $resp->rowCount();
        else:
            return null;
        endif;

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

        $per="SELECT p.permiso FROM rol_per as rp INNER JOIN roles as r ON rp.roll_id=r.id INNER JOIN permisos as p on per_id=p.id where r.rol='".$usuario[0]['rol_id']."'"; 
        
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

}