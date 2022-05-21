<?php namespace App\Controllers; //ee6d7cb4d452a291840473c1677e0779d03154206f79c386a48141ad43148b53

use Core\Controller;
use Core\Model;
use Core\View;
use Core\Helpers;
use Core\Mail;
use Core\Config;
use App\helpers\Ajax;
use App\helpers\Functions;
use App\helpers\FlowReport;
use \Dompdf\Dompdf;
use \stdClass;

defined("BASEPATH") or die("ACCESS DENIED");

class flow extends Controller
{
    private $FLOW_CONNECTOR;
    private $tarjetasModel;
    private $ventasModel;
    private $usuarioModel;
    private $pdf;
    private $email;
    function __construct()
    {
        parent::__construct();
        $this->FLOW_CONNECTOR = Helpers::loadHelper('flow')->getInstance();
        $this->tarjetasModel = Model::loadModel('tarjetas');
        $this->ventasModel = Model::loadModel('ventas');
        $this->usuarioModel = Model::loadModel('usuarios');
        $this->pdf = new Dompdf;
        $this->email = new Mail;
    }

    function index()
    {
        $pin = $this->tarjetasModel->getBasicPinById('3449');
        $order_data = $this->ventasModel->getBasicOrder('5570');

        var_dump($order_data);   
        var_dump($pin);   
        /*try {

            $html_template_pdf = FlowReport::templateFlowEmail(11111, 1212121212, 'clp 1000', 'fecha aqui', true);

            $html_template_email = FlowReport::templateFlowEmail(11111, 1212121212, 'clp 1000', 'fecha aqui', false);

            $this->pdf->set_paper('letter');
            $this->pdf->set_option('isRemoteEnabled', TRUE);
            $this->pdf->load_html($html_template_pdf);
            $this->pdf->render();
            $file = $this->pdf->output();

            $emailSending = $this->email->config(
                Config::EmailSender['cuenta'],
                Config::EmailSender['pass'],
                'Prueba nuevo email',
                'uzcateguijesusdev@gmail.com',
                'uzcateguijesusdev@gmail.com',
                'Email de prueba',
                $html_template_email,
                '',
                $file,
                'PDF desde template nuevo'
            );

            var_dump($emailSending);

        }catch(\Exception $e){
            var_dump($e->getMessage());
        }*/
    }

    function confirm(){
        $html_template_pdf = FlowReport::templateFlowEmail('12121212', '12121212', '1000', 'Fecha', true);
        $html_template_email = FlowReport::templateFlowEmail('12121212', '12121212', '1000', 'Fecha', false);
        
        $orden = "XXXXXXXXXXXXXXXXXXXXXXXXXX";
        
        $this->pdf->set_paper('letter');
        $this->pdf->set_option('isRemoteEnabled', TRUE);
        $this->pdf->load_html($html_template_pdf);
        $this->pdf->render();
        $file = $this->pdf->output();
        
        $emailSending = $this->email->config(
            Config::EmailSender['cuenta'],
            Config::EmailSender['pass'],
            'Compra N° ' . $orden . ' - Tarjetas Locutorios',
            'uzcateguijesusdev@gmail.com',
            'uzcateguijesusdev@gmail.com',
            'Compra N° ' . $orden . ' - Tarjetas Locutorios',
            $html_template_email,
            '',
            $file,
            'PDF desde template nuevo'
        );
        
        var_dump($emailSending);
    }
    
    

    function status(){
        try {
            $request = $_REQUEST;
            $orderId = $request['order'];
            $order_data = $this->ventasModel->getOrderInfo($orderId);
            $order_data->mensaje_webpay = json_decode($order_data->mensaje_webpay);
            http_response_code(200);
            echo json_encode($order_data);
            return;
        } catch(\Exception $e){
            http_response_code(400);
            echo json_encode(["Error" => $e->getMessage()]);
            return;
        }
    }

    function checkout(){
        $request = $_REQUEST;
        $cookies = $_COOKIE;
        
        //var_dump($request);
        if( isset($request['token']) == true ){
            try {

                $args = array(
                    "token" => $request['token']
                );
                
                $serviceName = "payment/getStatus";
                $statusPayment = $this->FLOW_CONNECTOR->send($serviceName, $args, 'GET');
                $pin = $this->tarjetasModel->getBasicPinById($cookies['lc_idtarjeta']);
                $orden = $this->ventasModel->getBasicOrder($cookies['lc_idventa']);
                
                if( $statusPayment['status'] == 2 ){   
                    
                    $this->ventasModel->actualizarventa($cookies['lc_idventa'], 3, 'Venta procesada con éxito', json_encode($statusPayment), date("Y-m-d H:i:s", time() ));
                    $this->ventasModel->actualizartarjeta($cookies['lc_idtarjeta'], 3);

                    $html_template_pdf = FlowReport::templateFlowEmail($orden->id_operacion, $pin->pin, $pin->precio, $orden->fin, true);

                    $html_template_email = FlowReport::templateFlowEmail($orden->id_operacion, $pin->pin, $pin->precio, $orden->fin, false);

                    $this->pdf->set_paper('letter');
                    $this->pdf->set_option('isRemoteEnabled', TRUE);
                    $this->pdf->load_html($html_template_pdf);
                    $this->pdf->render();
                    $file = $this->pdf->output();

                    $emailSending = $this->email->config(
                        Config::EmailSender['cuenta'],
                        Config::EmailSender['pass'],
                        'Compra N° ' . $orden->id_operacion . ' - Tarjetas Locutorios',
                        $orden->correo_cliente,
                        $orden->correo_cliente,
                        'Compra N° ' . $orden->id_operacion . ' - Tarjetas Locutorios',
                        $html_template_email,
                        '',
                        $file,
                        'PDF desde template nuevo'
                    );

                    echo 'Proccessing data... Please wait some time.';
                    sleep(3);
                    
                    header('Location: /#/compra/' . $cookies['lc_idventa']);                
                } else {
                    $this->ventasModel->actualizarventa($cookies['lc_idventa'], 5, 'Ha ocurrido un error', json_encode($statusPayment), date("Y-m-d H:i:s", time() ));
                    $this->ventasModel->actualizartarjeta($cookies['lc_idtarjeta'], 1);
                    $emailSending = $this->email->config(
                        Config::EmailSender['cuenta'],
                        Config::EmailSender['pass'],
                        'ERROR COMPRA FLOW - ' . $orden->id_operacion,
                        'uzcateguijesusdev@gmail.com',
                        'uzcateguijesusdev@gmail.com',
                        'Email de prueba',
                        '<p>Flow ha retornado un respuesta negativa con la siguiente compra: '.$orden->id_operacion.'</p><p><pre>'.json_encode($statusPayment).'</pre></p>',
                        ''
                    );    
                    header("Location: /#/error/payment/" . $cookies['lc_idventa']); 
                }
                return;

            } catch(\Exception $e){
                var_dump($e->getMessage());
            }
        } else {
            $this->ventasModel->actualizarventa($cookies['lc_idventa'], 5, 'Error al obtener token de verificación', 'N/A', date("Y-m-d H:i:s", time() ));
            $this->ventasModel->actualizartarjeta($cookies['lc_idtarjeta'], 1);
            header("Location: /#/error/payment/" . $cookies['lc_idventa']);
            return;
        }

    }
    
    function createSolicitud(){
        $request  = $_REQUEST;
        $correo   = $request['correo'];
        $telefono = $request['telefono'];
        
        $buscarVentaPorCorreo = $this->ventasModel->getFreecardd($correo, $telefono);

        if( $buscarVentaPorCorreo == false ){
            http_response_code(400);
            echo json_encode(["Ya tuviste tu regalo"]);
            return;
        } else {
            $generatePlasma = $this->ventasModel->getVentaFree($correo, $telefono);
            if($generatePlasma['data'] == 2){

                $html_template_pdf = FlowReport::templateFlowEmail($generatePlasma["datos"]["order"], $generatePlasma["datos"]["pin"]->pin, "REGALO", date("Y-m-d H:i:s",time()-3600), true);
                $html_template_email = FlowReport::templateFlowEmail($generatePlasma["datos"]["order"], $generatePlasma["datos"]["pin"]->pin, "REGALO", date("Y-m-d H:i:s",time()-3600), false);

                $this->pdf->set_paper('letter');
                $this->pdf->set_option('isRemoteEnabled', TRUE);
                $this->pdf->load_html($html_template_pdf);
                $this->pdf->render();
                $file = $this->pdf->output();

                $emailSending = $this->email->config(
                    Config::EmailSender['cuenta'],
                    Config::EmailSender['pass'],
                    'Compra N° ' . $generatePlasma["datos"]["order"] . ' - Tarjetas Locutorios',
                    $correo,
                    $correo,
                    'Compra N° ' . $generatePlasma["datos"]["order"] . ' - Tarjetas Locutorios',
                    $html_template_email,
                    '',
                    $file,
                    'PDF desde template nuevo'
                );
                
                http_response_code(200);
                echo json_encode(["Pin enviado"]);                
            } else {
                http_response_code(405);
                echo json_encode(["Error de servidor"]);
            }
        }
    }

    function createPaymentUrl(){
        $request  = $_REQUEST;
        $correo   = $request['correo'];
        $telefono = $request['telefono'];
        $precio   = $request['precio'];
        
        $compra = new stdClass;

        $compra->orderNumber = strval(rand(100000, 999999999));
        $compra->email = $correo;

        if( $precio == "1" ){
            $compra->ammount= 1000;
        }else if( $precio == "2" ){
            $compra->ammount= 2000;
        } else if( $precio == "3" ){
            $compra->ammount= 5000;
        } else if( $precio == "6" ){
            $compra->ammount= 10000;
        }

        //Tarjeta.................
        $tarjeta = $this->ventasModel->verifitarventa( intval( $precio ) );
        
        if( count($tarjeta) == 0 ){
            http_response_code(404);
            echo json_encode(["Message" => "Tarjeta de " . $compra->ammount . " No disponible"]);
            return;
        }

        $idTarjeta = intval($tarjeta[0]['id']);

        $userPayment = $this->tarjetasModel->getUserByEmail( $correo );
        
        $usuario = new stdClass;
        $usuario->id = 1;
        $usuario->email = $correo;

        if( is_array($userPayment) && count($userPayment) > 0 ){
            $usuario->id = 1;
            $usuario->email = 'abonos@locutorios.cl';
        }

        $datosVenta = array(
            "id_targeta" => $idTarjeta,
            "id_estatus" => 1,
            "fecha" => date("Y-m-d H:i:s",time()-3600),
            "id_operacion" => $compra->orderNumber,
            "id_usu" => $usuario->id,
            "correo" => $usuario->email,
            "correo_cliente" => $correo,
            "estado" => 2,
            "telefono" => $telefono,
            "tipo_venta" => "N/A",
            "mensaje_webpay" => "N/A",
            "inicio" => date("Y-m-d H:i:s",time()-3600),
        );

        //Guardar venta
        $ventaRecord = $this->ventasModel->savevent($datosVenta);

        if(is_null($ventaRecord)){
            http_response_code(500);
            echo json_encode(["Message" => "Error guardar venta"]);
            return;
        }

        /*setcookie('lc_idventa', $ventaRecord, time()+86400, '/', '.tarjetalocutorios.com', true, true);
        setcookie('lc_idtarjeta', $idTarjeta, time()+86400, '/', '.tarjetalocutorios.com', true, true);*/
        
        setcookie('lc_idventa', $ventaRecord, [
            'expires' => time() + 86400,
            'path' => '/',
            'domain' => 'tarjetalocutorios.com',
            'secure' => true,
            'httponly' => false,
            'samesite' => 'None',
        ]);
        
        setcookie('lc_idtarjeta', $idTarjeta, [
            'expires' => time() + 86400,
            'path' => '/',
            'domain' => 'tarjetalocutorios.com',
            'secure' => true,
            'httponly' => false,
            'samesite' => 'None',
        ]);


        //Actualizar tarjeta
        $actualizarTarjeta = $this->ventasModel->actualizartarjeta($idTarjeta, 2);

        if($actualizarTarjeta == false){
            http_response_code(405);
            echo json_encode(["Message" => "Error al actualizar tarjeta"]);
            return;
        }
        
        $args = array(
            "commerceOrder" => $compra->orderNumber,
            "subject" => 'Tarjeta locutorios - ' . $compra->ammount,
            "currency" => 'CLP',
            "amount" => $compra->ammount,
            "email" => $compra->email,
            "paymentMethod" => 9,
            "urlConfirmation" => Config::AppUrl['web'] . 'flow/confirm', 
            "urlReturn" => Config::AppUrl['web'] . 'flow/checkout',
            "optional" => json_encode([
                "telefono" => $telefono,
                "venta" => $ventaRecord,
                "pin" => $idTarjeta

            ])
        );

        $serviceName = "payment/create";

        try {
            http_response_code(200);
            $createPayment = $this->FLOW_CONNECTOR->send($serviceName, $args, 'POST');
            echo json_encode(array(
                "urlpago" => $createPayment['url'] .  '?token=' . $createPayment['token']
            ));
            return;
        } catch(\Exception $e){
            http_response_code(400);
            echo json_encode([
                "error" => $e->getMessage()
            ]);
            return;
        }
    }
}