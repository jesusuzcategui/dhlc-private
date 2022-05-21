
<?php
$modelo = \Core\Model::loadModel('auditoria');
$Acl = \Core\Model::loadModel('Acl');
$Acl->auditoria("REPORT","auditoria","",1);
if (isset($_GET['ini'])&&isset($_GET['fin'])){
  $data=[
            "fecha_init"=>$_GET['ini'],
            "fecha_fin" =>$_GET['fin'],
          ];
 $registro=$modelo->getTopactividades("rango",$data);
}else{
  $registro=$modelo->getTopactividades("");
}
$html = '<h1>Actividad de usuarios</h1><br><br><br>';
$html .= '<table>
            <thead>
              <tr>
                <th>CEDULA</th>
                <th>APELLIDOS</th>
                <th>METODO</th>
                <th>FECHA</th>
                <th>IP</th>
              </tr>
            </thead>
            <tbody>';
            foreach($registro as $row):
              $html .= '<tr>
                <td>'.$row['cedula'].'</td>
                <td>'.strtoupper($row['nombrepersona']).'</td>
                <td>'.$row['accion'].'</td>
                <td>'.$row['fecha'].'</td>
                <td>'.$row['ippersona'].'</td>
                </tr>
              ';
            endforeach;
            $html.= '</tbody>
          </table>
';
return $html;
