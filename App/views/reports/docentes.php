<?php
$modelo = \Core\Model::loadModel('docente');
$select = \Core\Model::loadModel('select');
// $Acl = \Core\Model::loadModel('Acl');


// $Acl->auditoria("REPORT","persona","",1);
$html = '<h1>Listado de Docentes</h1><br><br><br>';
$html .= '<table>
            <thead>
              <tr>
              <th>Cedula</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Categoria</th>
                <th>Dedicacion</th>
                <th>Condicion</th>
                <th>Documento</th>
                <th>Estatus</th>
              </tr>
            </thead>
            <tbody>';
             $roll=[];

            foreach($modelo->getDocs(null,"reporte") as $row):               
              $html .= '<tr>
                <td>'.$row['cedula'].'</td>
                <td>'.$row['nombre'].'</td>
                <td>'.$row['apellido'].'</td>
                <td>'.$row['categoria'].'</td>
                <td>'.$row['dedicacion'].'</td>
                <td>'.$row['condicion'].'</td>
                <td>'.$row['documento'].'</td>
                <td>'.$row['estatus'].'</td>
                </tr>
              ';
            endforeach;
            $html.= '</tbody>
          </table>
';
return $html;


