<?php
$modelo = \Core\Model::loadModel('usuarios');
$registro=$modelo->getUsus();

$html = '<h1>Registros de usuarios</h1><br><br><br>';
$html .= '<table>
            <thead>
              <tr>
                <th>Id</th>
                <th>RUT</th>
                <th>Email</th>
                <th>Telefono</th>
                <th>Nivel</th>
              </tr>
            </thead>
            <tbody>';
            foreach($registro as $row):
              $html .= '<tr>
                <td>'.$row['id'].'</td>
                <td>'.$row['cedula'].'</td>
                <td>'.$row['email'].'</td>
                <td>'.$row['telefono'].'</td>
                <td>'.$row['roll'].'</td>
                </tr>
              ';
            endforeach;
            $html.= '</tbody>
          </table>
';
return $html;
