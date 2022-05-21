<?php
ini_set("memory_limit", "1024M");
$modelo = \Core\Model::loadModel('tarjetas');
$registro=$modelo->getCardPerPage(null, 3000);

$html = '<h1>Registros de tarjetas</h1><br><br><br>';
$html .= '<table>
            <thead>
              <tr>
                <th>Cod</th>
                <th>PIN</th>
                <th>Precio</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tbody>';
foreach($registro as $item):
$html .=    '<tr>
              <td>'.$item['cod_targ'].'</td>
              <td>'.$item['pin'].'</td>
              <td>'.$item['precio'].'</td>
              <td>'.$item['estado'].'</td>
            </tr>';
endforeach;
$html .= '</tbody>
        </table>';
return $html;