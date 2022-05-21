<?php
$modelo = \Core\Model::loadModel('Persona');
$select = \Core\Model::loadModel('select');
// $Acl = \Core\Model::loadModel('Acl');
$reroll=new datos();

// $Acl->auditoria("REPORT","persona","",1);
$html = '<h1>Listado de Personas</h1><br><br><br>';
$html .= '<table>
            <thead>
              <tr>
               <th>Cedula</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Correo</th>
                <th>Roles</th>
                <th>Fecha Nacimiento</th>
                <th>Estatus</th>
              </tr>
            </thead>
            <tbody>';
             $roll=[];

            foreach($modelo->getPers() as $row):
               $todosroles=$select->roll();
               $roles=$reroll->regiroll($row['rolls_id'],$todosroles);
                              
              $html .= '<tr>
                <td>'.$row['cedula'].'</td>
                <td>'.$row['nombre'].'</td>
                <td>'.$row['apellido'].'</td>
                <td>'.$row['correo'].'</td>
                <td>'.$roles.'</td>
                <td>'.$row['fecha_nacimiento'].'</td>
                <td>'.$row['estatus'].'</td>
                </tr>
              ';
            endforeach;
            $html.= '</tbody>
          </table>
';
return $html;

class datos{

 public function regiroll($roll,$todosroles){
    $roles = explode(",", $roll);
  //  $selectMod   = \Core\Model::loadModel('select');
     
       $roll=[];
      for( $i=0; $i<count($roles);$i++){
             //console.log(e[i].descripcion);
            for($j=0; $j<count($todosroles);$j++){
               if ($todosroles[$j]['id']==$roles[$i]){
                //console.log(e[i].descripcion);
               array_push($roll,$todosroles[$j]['descripcion']);
              }
            }
            
         }
        return implode(",", $roll);
  }
}
