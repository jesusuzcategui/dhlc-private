<?php
$modelo = \Core\Model::loadModel('ventas');
$registro=$modelo->getvent();

$html = '<h1>Registros de ventas</h1><br><br><br>';
$html .= '<table>
            <thead>
              <tr>
                <th style="font-size: 13px !important; text-align: center;" width="15%">N° de operación</th>
                <th style="font-size: 13px !important; text-align: center;" width="10%">Pin</th>
                <th style="font-size: 13px !important; text-align: center;" width="10%">Precio</th>
                <th style="font-size: 13px !important; text-align: center;" width="15%">Fecha</th>
                <th style="font-size: 13px !important; text-align: center;" width="30%">Correo</th>
                <th style="font-size: 13px !important; text-align: center;" width="10%">Teléfono</th>
                <th style="font-size: 13px !important; text-align: center;" width="10%">Estado</th>
              </tr>
            </thead>
            <tbody>';
            foreach($registro as $row):
              $html .= '<tr>
                <td style="font-size: 12px !important; text-align: center;">'.$row['id_operacion'].'</td>
                <td style="font-size: 12px !important; text-align: center;">'.$row['pin'].'</td>
                <td style="font-size: 12px !important; text-align: center;">'.$row['precio'].' CLP</td>
                <td style="font-size: 12px !important; text-align: center;">'.$row['fecha'].'</td>
                <td style="font-size: 12px !important; text-align: center;">'.$row['correo_cliente'].'</td>
                <td style="font-size: 12px !important; text-align: center;">'.$row['telefono'].'</td>
                <td style="font-size: 12px !important; text-align: center;">'.$row['estado'].'</td>
                </tr>
              ';
            endforeach;
            $html.= '</tbody>
          </table>
';
return $html;

