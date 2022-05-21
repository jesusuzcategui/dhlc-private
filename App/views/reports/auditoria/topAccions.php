<?php
$modelo = \Core\Model::loadModel('auditoria');
$auditoria = $modelo->getTopactividades();

$html = '<h1>Listado Actividades de usuario id: '.$_GET['id'].'</h1><br>
          <table class="table_report">
            <thead>
              <tr>
                <th>Cedula</th>
                <th>Persona</th>
                <th>Ip</th>
                <th>Metodo</th>
              </tr>
            </thead>
            <tbody>';

foreach($personas as $persona):

  $html .= '<tr>
              <td>'.$persona['id'].'</td>
              <td>'.$persona['correo'].'</td>
              <td>'.$persona['contra'].'</td>
              <td>'.(($persona['estatus'] == 1) ? 'Activo' : 'Inactivo').'</td>
            </tr>';

endforeach;

$html .= '
            </tbody>
          </table>
';

return $html;
