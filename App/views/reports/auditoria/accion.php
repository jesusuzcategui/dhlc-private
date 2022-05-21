<?php
$modelo = \Core\Model::loadModel('auditoria');

$vista=new Renderview();
$action=$_GET["action"];
switch ($action) {
  case 'INSERT':
   if(isset($_GET['ini'])&&isset($_GET['fin'])){
    $data=["fechainit"=>$_GET['ini'],"fechafin" =>$_GET['fin']];
    $registro=$modelo->cant_update($_GET['action'],"REPORTRANGO",$data);
     return $vista->vista($registro);
   }else{
    $registro=$modelo->cant_update($_GET['action'],"REPORT");
     return $vista->vista($registro);
   }
    
    break;
  case 'UPDATE':
   if(isset($_GET['ini'])&&isset($_GET['fin'])){
      $data=[
            "fechainit"=>$_GET['ini'],
            "fechafin" =>$_GET['fin'],
          ];
    $registro=$modelo->cant_update($_GET['action'],"REPORTRANGO",$data);
      return $vista->vista($registro);
      //return $data;
   }else{
    $registro=$modelo->cant_update($_GET['action'],"REPORT");
      return $vista->vista($registro);
   }
    break;
  case 'DELETE':
   if(isset($_GET['ini'])&&isset($_GET['fin'])){
        $data=[
            "fechainit"=>$_GET['ini'],
            "fechafin" =>$_GET['fin'],
          ];
    $registro=$modelo->cant_update($_GET['action'],"REPORTRANGO",$data);
      return $vista->vista($registro);
   }else{
    $registro=$modelo->cant_update($_GET['action'],"REPORT");
      return $vista->vista($registro);
   }
    break;
  case 'REPORT':
   if(isset($_GET['ini'])&&isset($_GET['fin'])){
        $data=[
            "fechainit"=>$_GET['ini'],
            "fechafin" =>$_GET['fin'],
          ];
    $registro=$modelo->cant_update($_GET['action'],"REPORTRANGO",$data);
      return $vista->vista($registro);
   }else{
    $registro=$modelo->cant_update($_GET['action'],"REPORT");
      return $vista->vista($registro);
   }
    break;
  
 
}

class Renderview{
 public $Acl;
  public function __construct()
  {
    $this->Acl = \Core\Model::loadModel('Acl');
  }
function vista($register){
  $this->Acl->auditoria("REPORT","auditoria","",1);
$html = '<h1> Acciones de Usuarios</h1><br><br><br>';
$html .= '<table>
             <thead>
              <tr>
                 <th>CEDULA</th>
                 <th>NOMBRE</th>
                 <th>MODULO</th>
                 <th>IP</th>
                 <th>ACCION</th>
                 <th>FECHA</th>
               </tr>
             </thead>
             <tbody>';
             foreach($register as $row):
              $html .= '<tr>
                 <td>'.$row['cedula'].'</td>
                 <td>'.$row['nombrepersona'].'</td>
                 <td>'.$row['tabla'].'</td>
                 <td>'.$row['ippersona'].'</td>
                 <td>'.$row['accion'].'</td>
                 <td>'.$row['fecha'].'</td>
                 </tr>
               ';
             endforeach;
             $html.= '</tbody>
           </table>
 ';
return $html;

}
}

