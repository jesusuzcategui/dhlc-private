<?php

/*
Job: Verification of sales and cards.
@author: Jesus Uzcategui
*/

require_once __DIR__  . '/defines.php';

date_default_timezone_set('America/Santiago');

require_once __DIR__  . '/Core/Medoo.php';

USE Core\Medoo;
USE \PDO as drivep;

$fileLog = fopen(__DIR__ . '/webpay.log','a');

$medoo = new Medoo([
    // required
    'database_type' => "mysql",
    'database_name' => "tarjetas_sistemalocutorios",
    'server' => "localhost",
    'username' => "tarjetas_sistemalocutorios",
    'password' => "LoCard1298_56",
 
    // [optional]
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_general_ci',
    'port' => 3306
]);

//Begin

/*#Saber que día es hoy.
$current_day = date('Y-m-d H:i:s');

#Consultar ventas del día.
$query = "SELECT * FROM ventas_frecuentes WHERE date(inicio) = '".date('Y-m-d')."'";
#$query = "SELECT * FROM ventas_frecuentes ORDER BY id DESC";

$data = $medoo->query($query)->fetchAll(drivep::FETCH_ASSOC);

#recorremos los registros.
foreach($data as $venta):
    $inicio = $venta['inicio'];
    $dateI  = date($inicio);
    $dateN  = strtotime($current_day); 
    $horaA  = $venta['inicio'];
    $horaB  = strtotime('+50 minute', strtotime($horaA));
    $horaC  = date('Y-m-d H:i:s', $horaB);
    if($dateN > $horaB){
        if( intval($venta['estado']) == 2 ){
            $update = $medoo->update('ventas_frecuentes', 
                [
                    'estado' => 5,
                    'fin'    => $horaC,
                    'mensaje_webpay' => 'No se recibió ninguna respuesta por parte de webpay o el cliente no finalizó la compra.'
                ], 
                [
                    'id' => intval($venta['id'])
                ]);

            if($update->rowCount() >= 1){
                $tarjeta = $medoo->update('targetas', ['estado_id' => 1], [
                    'id' => intval($venta['id_targeta']),
                    'estado_id' => 2
                ]);

                $logMsg = "[CRONJOB - Message]\n[Fecha: ".date('r')." | Orden: ".$venta['id_operacion']."]\n[Message: Actualizada la venta a elimanada]\n\n";

                fwrite($fileLog, $logMsg);
		        fclose($fileLog);

                print_r($logMsg);

                if($tarjeta->rowCount() >= 1){
                    $logMsg = "[CRONJOB - Message]\n[Fecha: ".date('r')." | Orden: ".$venta['id_operacion']."]\n[Message: Se actualizó la tarjeta.]\n\n";
                } else {
                    $logMsg = "[CRONJOB - Message]\n[Fecha: ".date('r')." | Orden: ".$venta['id_operacion']."]\n[Message: No fue necesaria la actualización de la tarjeta.]\n\n";
                }

                fwrite($fileLog, $logMsg);
		        fclose($fileLog);

                print_r($logMsg);

            } else {
                print_r(["Error en la de fecha " . $venta['inicio'] ]);
            }
        }
    }
endforeach;*/