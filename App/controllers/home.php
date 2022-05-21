<?php namespace App\Controllers; //ee6d7cb4d452a291840473c1677e0779d03154206f79c386a48141ad43148b53

use Core\Controller;
use Core\Model;
use Core\View;
use Core\Helpers;
use Core\Mail;
use Core\Config;
use App\helpers\Ajax;
use App\helpers\Functions as funciones;
use App\helpers\compra;
use App\helpers\webpayhelper;
use Transbank\Webpay\Configuration;
use Transbank\Webpay\Webpay;
use \Dompdf\Dompdf;
use \stdClass;

defined("BASEPATH") or die("ACCESS DENIED");

class home extends Controller
{
    private $modUser;
    private $mdemcript;
    private $mod;
    private $ven;
    private $validate;
    public $email;
    public $pdf;
    public $transaction;

    function __construct()
    {
        parent::__construct();

        $this->modUser = Model::loadModel('usuarios');
        $this->mod=Model::loadModel('tarjetas');
        $this->ven=Model::loadModel('ventas');
        $this->mdemcript = Helpers::loadHelper('Auth');
        $this->pdf = new Dompdf;
        $this->email= new Mail(); //
        

       try {
           
           $this->transaction = new webpayhelper(true);
        

       } catch (\Exception $e) {
         echo '<div class="uk-alert-danger" uk-alert>
             <a class="uk-alert-close" uk-close></a>
             <h4 class="uk-text-center">Sin conexión con webpay</h4>
             <p class="uk-text-center">Por favor recarga el sitio para comprobar la conexión</p>
         </div>';
       }
    }

    function index()
    {
        //View::render(__CLASS__, 'homenuevo', 'Compra de PIN');
        //View::render(__CLASS__, 'modoblock', 'Compra de PIN');
        View::render(__CLASS__, 'home_nuevo/index', 'Tarjeta de llamadas');
        /*Hello*/
        
    }
    
    function ventatest(){
        View::render(__CLASS__, 'homenuevo', 'Compra de PIN');
    }

    function tipoventa($tipo){

        switch ($tipo) {
            case 'VD':
                return "Venta Débito.";
                break;
            case 'VN':
                return "Venta Normal.";
                break;
            case 'VC':
                return "Venta en cuotas.";
                break;
            case 'SI':
                return "3 cuotas sin interés.";
                break;
            case 'S2':
                return "2 cuotas sin interés.";
                break;
            case 'NC':
                return "N Cuotas sin interés";
                break;
            case 'VP':
                return "Venta Prepago.";
                break;
            case '':
              return "Rechazo de transacción.";
            break;
            default:
              return "Rechazo de transacción.";
            break;
        }
    }

    function parseResponseCode($valor){
      
    }
    
    function testemailwithfile(){
        //error_reporting(0);
        
        #Configurando archivo de factura.
        $mensajePdf    = funciones::getHTMLPdf(00000000, 123456789, 1000, funciones::getLogoToEmail(1));
        //NORMAL
        $mensajeCorreo = funciones::getHTMLToEmail(00000000, 123456789, 1000, funciones::getLogoToEmail(2));
        
        $this->pdf->set_paper('letter');
        //$file    = include('../App/views/reports/recarga.php');
        $this->pdf->load_html( $mensajePdf );
        $this->pdf->render();
        //$this->pdf->stream("dompdf_out.pdf", array("Attachment" => false));
        $archivo = $this->pdf->output();
        
        $mensaje = $mensajeCorreo;

        #Enviando correo.
        $send    = $this->email->config(Config::EmailSender["cuenta"], Config::EmailSender["pass"], 'Sistema Locutorios', 'uzcateguijesusdev@gmail.com', 'uzcateguijesusdev@gmail.com','Compra de PIN #0000000000', $mensaje, 'este es un mensaje adicional', $archivo,'Invoice_Compra_0001001001.pdf');
        
        var_dump($send);
    }

    private function pagos($amount, $return, $final){
        $amount =$amount;
        // Identificador que será retornado en el callback de resultado:
        $sessionId = session_id();
        // Identificador único de orden de compra:
        $buyOrder = strval(rand(100000, 999999999));
        $returnUrl = $return;
        $finalUrl = $final;
        
        $this->transaction->ammount = $amount;
        $this->transaction->order = $buyOrder;
        $this->transaction->return = $returnUrl;
        $this->transaction->finish = $finalUrl;
        $this->transaction->session = $sessionId;

        $initResult = $this->transaction->init();
        $data = new stdClass();

        if(!is_array($initResult)){

        	$formAction = $initResult->url;

	        $tokenWs = $initResult->token;

	        $data->error = null;

	        $data->action   = $formAction;
	        $data->token_ws = $tokenWs;
	        $data->order    = $buyOrder;

        } else {

        	$data->error = $initResult['error'];

        }

        return $data;
    }

    private function clearSession(){
      unset($_SESSION['tipotrans']);
      unset($_SESSION['tarjeta']);
      unset($_SESSION['Tgr']);
      unset($_SESSION["ventaid"]);
      unset($_SESSION['Monto']);
      unset($_SESSION['token']);
      unset($_SESSION['status']);
      unset($_SESSION['email']);
      unset($_SESSION['email_cliente']);
      unset($_SESSION['res']);
      unset($_SESSION['compra']);
      unset($_SESSION['responseCode']);
      $_SESSION = null;
    }
    
    function retorno(){
        
        //session_start();
        
        $request = $_REQUEST; //CAPTURAR PAYLOAD
        $session = $_SESSION;
        $cook    = $_COOKIE;
        
        //var_dump($request);
        //var_dump($session);
        //var_dump($cook);
        
        if(!isset( $request['token_ws'] )){ //VERIFICAR SI WEBPAY RETORNO EL TOKEN
            //REDIGIR AL FINAL PAGE FOR ERROR.
            funciones::writeLog('RETURN', 'WEBPAY NO RETORNO TOKEN');
            funciones::writeLog('RETURN', 'Webpay no retorno una respuesta valida');
            
            #Actualizamos la venta y la tarjeta
            $updateVenta  = $this->ven->actualizarventa($_SESSION["ventaid"], 5, 'N/A', 'N/A', date("Y-m-d H:i:s", time() ));
            $updateTajeta = $this->ven->actualizartarjeta( $_SESSION['Tgr'], 1 );
                        
            #Comprobamos la actualización en la base de datos.                        
            if( !$updateVenta && !$updateTajeta ){

                funciones::writeLog('finish', 'Error al actualizar base de datos de tarjeta y venta');
                $mensaje = "<p>Se ha presentado un error en la actualización de la venta <strong>".$_SESSION["ventaid"]."</strong> en el sistema el día: <strong>".date("Y-m-d H:i:s",time())."</strong>, por favor revisar urgentemente.</p><p> Error: ".$result['error']."</p>";

                #Enviamos un email.
                $this->email->config(
                        Config::EmailSender["cuenta"],
                        Config::EmailSender["pass"],
                        'Sistema Locutorios: Error estado de Venta',
                        Config::EmailSupport,
                        Config::EmailSupport,
                        'Compra #'.$_SESSION["ventaid"].' - Sistema Pines Locutorios',
                        $mensaje, 'este es un mensaje adicional'
                    );

            }
                        
            #Establecemos el estatus de la compra
            $_SESSION['compra_status'] = false;
            #Redirigimos al finish con un error.
            header('Location: '. funciones::permalink() . 'home/finish?error=1');
            exit;
        } else {
            
            $operacion = new webpayhelper(true);
            $operacion->token = $request['token_ws'];
            $resultado = $operacion->verifyToken();
            
            #Escribimos en el log la información obtenida del token
            funciones::writeLog('return', json_encode($resultado));
            
            //COMPROBAMOS QUE EXISTA UN DETAIL OUTPUT...
            
            if( isset( $resultado->detailOutput ) ){
                
                if( isset( $resultado->detailOutput->responseCode ) ){
                    $responseCode = $resultado->detailOutput->responseCode;
                    if( $responseCode === 0 ){ 
                        
                        #Actualizamos la venta y la tarjeta
                        $updateVenta  = $this->ven->actualizarventa($_SESSION["ventaid"], 3, 'N/A', 'N/A', date("Y-m-d H:i:s", time() ));
                        
                        $updateTajeta = $this->ven->actualizartarjeta( $_SESSION['Tgr'], 3 );
                        
                        #Comprobamos la actualización en la base de datos.                        
                        if( !$updateVenta && !$updateTajeta ){
                            
                            funciones::writeLog('finish', 'Error al actualizar base de datos de tarjeta y venta');
                            $mensaje = "<p>Se ha presentado un error en la actualización de la venta <strong>".$_SESSION["ventaid"]."</strong> en el sistema el día: <strong>".date("Y-m-d H:i:s",time())."</strong>, por favor revisar urgentemente.</p><p> Error: ".$result['error']."</p>";
                            
                            #Enviamos un email.
                            $this->email->config(
                                    Config::EmailSender["cuenta"],
                                    Config::EmailSender["pass"],
                                    'Sistema Locutorios: Error estado de Venta',
                                    Config::EmailSupport,
                                    Config::EmailSupport,
                                    'Compra #'.$_SESSION["ventaid"].' - Sistema Pines Locutorios',
                                    $mensaje, 'este es un mensaje adicional'
                                );
                            
                        }
                        
                        $tarjeta = $this->ven->verifitarventa(null, intval($_SESSION['Tgr']));
                        
                        $_SESSION['compra_status'] = true; #Validamos la compra
                        $_SESSION['compra_token']  = $operacion->token; #Guardamos el token.
                        $_SESSION['compra_code']   = $responseCode;
                        $_SESSION['compra_tipo']   = $resultado->detailOutput->paymentTypeCode;
                        $_SESSION['compra_monto']  = $resultado->detailOutput->amount;
                        $_SESSION['compra_tarjeta']= $tarjeta[0]['targeta'];
                        
                        error_reporting(0);
                        
                        #Configurando archivo de factura.
                        $mensajePdf    = funciones::getHTMLPdf($_SESSION["ventaid"], $_SESSION['compra_tarjeta'], $_SESSION['compra_monto'], funciones::getLogoToEmail(1));
                        //NORMAL
                        $mensajeCorreo = funciones::getHTMLToEmail($_SESSION["ventaid"], $_SESSION['compra_tarjeta'], $_SESSION['compra_monto'], funciones::getLogoToEmail(2));
                        //BLACKFRIDAY
                        //$mensajeCorreo = funciones::HtmlBlackFriday($_SESSION["ventaid"], $_SESSION['compra_tarjeta'], $_SESSION['compra_monto'], funciones::getLogoToEmail(2), funciones::getMonoToEmail(2));
                        
                        $this->pdf->set_paper('letter');
                        //$file    = include('../App/views/reports/recarga.php');
                        $this->pdf->load_html( utf8_decode($mensajePdf) );
                        $this->pdf->render();
                        $archivo = $this->pdf->output();
                        
                        $mensaje = $mensajeCorreo;

                        #Enviando correo.
                        $send    = $this->email->config(Config::EmailSender["cuenta"], Config::EmailSender["pass"], 'Sistema Locutorios', $_SESSION['email_cliente'], $_SESSION['email_cliente'],'Compra de PIN #'.$_SESSION["ventaid"], $mensaje, 'este es un mensaje adicional');
                        
                        echo '<p>Procesando...</p>';
                        echo '<form id="webpay" method="POST" action="'.$resultado->urlRedirection.'">
                                <input type="hidden" name="token_ws" value="'.$request['token_ws'].'" />
                              </form>
                              <script type="text/javascript">
                                var forma = document.getElementById("webpay");
                                if(forma){
                                    setTimeout(function(){
                                        forma.submit();
                                    }, 500);
                                    
                                }
                              </script>';
                        
                        exit;
                    } else {
                        #Actualizamos la venta y la tarjeta
                        $updateVenta  = $this->ven->actualizarventa($_SESSION["ventaid"], 5, "N/A", "N/A", date("Y-m-d H:i:s",time()) );
                        
                        $updateTajeta = $this->ven->actualizartarjeta( $_SESSION['Tgr'], 1 );
                        
                        #Comprobamos la actualización en la base de datos.                        
                        if( !$updateVenta && !$updateTajeta ){
                            
                            funciones::writeLog('finish', 'Error al actualizar base de datos de tarjeta y venta');
                            $mensaje = "<p>Se ha presentado un error en la actualización de la venta <strong>".$_SESSION["ventaid"]."</strong> en el sistema el día: <strong>".date("Y-m-d H:i:s",time())."</strong>, por favor revisar urgentemente.</p><p> Error: ".$result['error']."</p>";
                            
                            #Enviamos un email.
                            $this->email->config(
                                    Config::EmailSender["cuenta"],
                                    Config::EmailSender["pass"],
                                    'Sistema Locutorios: Error estado de Venta',
                                    Config::EmailSupport,
                                    Config::EmailSupport,
                                    'Compra #'.$_SESSION["ventaid"].' - Sistema Pines Locutorios',
                                    $mensaje, 'este es un mensaje adicional'
                                );
                            
                        }
                        
                        #Establecemos el estatus de la compra
                        $_SESSION['compra_status'] = false;
                        $_SESSION['compra_token']  = $operacion->token; #Guardamos el token.
                        $_SESSION['compra_code']   = $responseCode;
                        $_SESSION['compra_tipo']   = $resultado->detailOutput->paymentTypeCode;
                        $_SESSION['compra_monto']  = $resultado->detailOutput->amount;
                        #Redirigimos al finish con un error.
                        header('Location: '. funciones::permalink() . 'home/finish');
                        exit;
                    }
                    
                } else {
                    
                    funciones::writeLog('RETURN', 'Webpay no retorno el reponse code');
                    
                        #Actualizamos la venta y la tarjeta
                        $updateVenta  = $this->ven->actualizarventa($_SESSION["ventaid"], 5, "N/A", "N/A", date("Y-m-d H:i:s",time()) );
                        $updateTajeta = $this->ven->actualizartarjeta( $_SESSION['Tgr'], 1 );
                        
                        #Comprobamos la actualización en la base de datos.                        
                        if( !$updateVenta && !$updateTajeta ){
                            
                            funciones::writeLog('finish', 'Error al actualizar base de datos de tarjeta y venta');
                            $mensaje = "<p>Se ha presentado un error en la actualización de la venta <strong>".$_SESSION["ventaid"]."</strong> en el sistema el día: <strong>".date("Y-m-d H:i:s",time())."</strong>, por favor revisar urgentemente.</p><p> Error: ".$result['error']."</p>";
                            
                            #Enviamos un email.
                            $this->email->config(
                                    Config::EmailSender["cuenta"],
                                    Config::EmailSender["pass"],
                                    'Sistema Locutorios: Error estado de Venta',
                                    Config::EmailSupport,
                                    Config::EmailSupport,
                                    'Compra #'.$_SESSION["ventaid"].' - Sistema Pines Locutorios',
                                    $mensaje, 'este es un mensaje adicional'
                                );
                            
                        }
                        
                        #Establecemos el estatus de la compra
                        $_SESSION['compra_status'] = false;
                        #Redirigimos al finish con un error.
                        header('Location: '. funciones::permalink() . 'home/finish?error=1');
                        exit;
                }
            } else {
                funciones::writeLog('RETURN', 'Webpay no retorno una respuesta valida');
                    
                    #Actualizamos la venta y la tarjeta
                        $updateVenta  = $this->ven->actualizarventa($_SESSION["ventaid"], 5, "N/A", "N/A", date("Y-m-d H:i:s",time()) );
                        $updateTajeta = $this->ven->actualizartarjeta( $_SESSION['Tgr'], 1 );
                        
                        #Comprobamos la actualización en la base de datos.                        
                        if( !$updateVenta && !$updateTajeta ){
                            
                            funciones::writeLog('finish', 'Error al actualizar base de datos de tarjeta y venta');
                            $mensaje = "<p>Se ha presentado un error en la actualización de la venta <strong>".$_SESSION["ventaid"]."</strong> en el sistema el día: <strong>".date("Y-m-d H:i:s",time())."</strong>, por favor revisar urgentemente.</p><p> Error: ".$result['error']."</p>";
                            
                            #Enviamos un email.
                            $this->email->config(
                                    Config::EmailSender["cuenta"],
                                    Config::EmailSender["pass"],
                                    'Sistema Locutorios: Error estado de Venta',
                                    Config::EmailSupport,
                                    Config::EmailSupport,
                                    'Compra #'.$_SESSION["ventaid"].' - Sistema Pines Locutorios',
                                    $mensaje, 'este es un mensaje adicional'
                                );
                            
                        }
                        
                        #Establecemos el estatus de la compra
                        $_SESSION['compra_status'] = false;
                        #Redirigimos al finish con un error.
                        header('Location: '. funciones::permalink() . 'home/finish?error=1');
                        exit;
            }
            
        }

    }

    function finish(){
        //session_start();
        #VARIABLES
        $session = $_SESSION;
        $params  = $_REQUEST;
        if(!isset($session['compra_status'])){
            
            //REDIGIR AL FINAL PAGE FOR ERROR.
            funciones::writeLog('RETURN', 'WEBPAY NO RETORNO TOKEN');
            funciones::writeLog('RETURN', 'Webpay no retorno una respuesta valida');
            
            #Actualizamos la venta y la tarjeta
            $updateVenta  = $this->ven->actualizarventa($_SESSION["ventaid"], 5, 'N/A', 'N/A', date("Y-m-d H:i:s", time() ));
            $updateTajeta = $this->ven->actualizartarjeta( $_SESSION['Tgr'], 1 );
                        
            #Comprobamos la actualización en la base de datos.                        
            if( !$updateVenta && !$updateTajeta ){

                funciones::writeLog('finish', 'Error al actualizar base de datos de tarjeta y venta');
                $mensaje = "<p>Se ha presentado un error en la actualización de la venta <strong>".$_SESSION["ventaid"]."</strong> en el sistema el día: <strong>".date("Y-m-d H:i:s",time())."</strong>, por favor revisar urgentemente.</p><p> Error: ".$result['error']."</p>";

                #Enviamos un email.
                $this->email->config(
                        Config::EmailSender["cuenta"],
                        Config::EmailSender["pass"],
                        'Sistema Locutorios: Error estado de Venta',
                        Config::EmailSupport,
                        Config::EmailSupport,
                        'Compra #'.$_SESSION["ventaid"].' - Sistema Pines Locutorios',
                        $mensaje, 'este es un mensaje adicional'
                    );

            }
            
            $view = 2;
            
        } else {
            
            if( !isset($params['error']) || empty($params['error']) || is_null($params['error']) ){
                if( $session['compra_status'] === true ){

                    $view    = 0;

                    $monto   = $session['compra_monto'];

                    $tarjeta = $this->ven->verifitarventa(null, intval($session['Tgr']));

                    $pin     = $tarjeta[0]["targeta"];

                    $email   = $session["email_cliente"];

                } else {     

                    $view = 1;

                }
            } else {
                $view = 2;
            }

        }
        
        View::set('view', $view);
        View::set('compra', (isset($session['compra']) ? $session['compra'] : ''));
        View::set('pin',    (isset($tarjeta[0]["targeta"]) ? $tarjeta[0]["targeta"] : ''));
        View::set('monto',  (isset($session['compra_monto']) ? $session['compra_monto'] : ''));
        View::set('email',  (isset($session["email_cliente"]) ? $session["email_cliente"] : ''));
        
        View::render(__CLASS__, 'final', 'Resultado de la compra');
    }

    public function testemail(){
        $email = funciones::HtmlBlackFriday('12131312', '0981241212', '1000', funciones::getLogoToEmail(2), funciones::getMonoToEmail(2));
        $pdf   = funciones::getHTMLToEmail('12131312', '0981241212', '1000', funciones::getLogoToEmail(1));
        
        $this->pdf->set_paper('letter');
        //$file    = include('../App/views/reports/recarga.php');
        $this->pdf->load_html( utf8_decode($pdf) );
        $this->pdf->render();
        $archivo = $this->pdf->output();

        $send = $this->email->config(
            Config::EmailSender["cuenta"],
            Config::EmailSender["pass"],
            'Sistema Locutorios', 
            'uzcateguijesusdev@gmail.com',
            'uzcateguijesusdev@gmail.com', 
            'TEST EMAIL',
            $email,
            'este es un mensaje adicional', 
            $archivo,
            'EMAIL TEST.pdf');
        echo $send;
    }


    public function logout(){
        
        if( session_destroy() || session_unset()  ){

          $return = true;

        } else {
          $return = false;
        }

        return $return;
     }

    function ajax($action=null)
    {
        if( $action != null ){
            if(Ajax::isAjax()){
                switch ($action){
                    case 'login':
                        $response = [];
                        if( $this->modUser->verifyEmail( $this->post('email') ) == false ){
                            $response = ["response" => 1];
                        } else {

                            $dato=$this->post('contra');
                            $dato_encriptado =$this->mdemcript->encriptar($dato);

                            if( $this->modUser->verifyUser(array('email' => $this->post('email'),'contra' => $dato_encriptado)) == false ){
                                $response = ["response" => 2];
                            } else {
                                 $_SESSION['email']   = $this->post('email');
                                 $locutk = $this->mdemcript->loadJWT();
                                 $_SESSION['locutok'] = $locutk;
                                 $response= [
                                     "response" => 3,
                                     "message"  => "Bienvenido",
                                     "token"    => $locutk,
                                     "status"   => 200
                                ];
                            }
                        }
                        print_r( json_encode(["data" => $response]));
                    break;
                    case 'logout':
                            //print_r($response);
                            $session=$this->logout();
                            print_r(json_encode(["data" => $session]));
                    break;
                    case 'precio':
                    print_r( json_encode( $this->mod->getprecio()) );
                    break;
                    case 'savere':
                    break;
                }
            }
        }
    }

    function proccesspayment(){
        $tarjeta = $this->ven->verifitarventa(
            intval($this->input()->post('precio'))
        );

        #Si existen tarjetas
        if(count($tarjeta)>0){
            #Se verifica si el correo enviado es un usuario del sistema.
            $usuario=$this->mod->getUserByEmail($this->input()->post('correo'));

            #Asignación de variables de session.
            $_SESSION['email']         = $this->input()->post('correo');
            $_SESSION['email_cliente'] = $this->input()->post('correo');


            #Identificación de los clientes.
            if(is_array($usuario) && count($usuario) > 0){
                $usuario = intval($usuario[0]['id']);
                $emailUs = 'abonos@locutorios.cl';
            }else{
                $usuario=1;
                $emailUs = $_SESSION['email'];
            }

            #Iniciamos la transaccion
            $webpay = $this->pagos(
                intval($tarjeta[0]['monto']),
                funciones::permalink() . "home/retorno",
                funciones::permalink() . "home/finish"
            );

            if($webpay->error == null){
                #Guardando datos de venta.
                $_SESSION['Tgr']           = intval($tarjeta[0]['id']); #id de la tarjeta
                $_SESSION['compra']        = $webpay->order;
                setcookie("Trgcook", intval($tarjeta[0]['id']));
                setcookie("compracook", intval($webpay->order));

                #Guardamos por primera vez la venta en la db
                $datosVenta=array(
                    "id_targeta"       => $_SESSION['Tgr'],
                    "id_estatus"       => 1,
                    "fecha"            => date("Y-m-d H:i:s",time()-3600),
                    "id_operacion"     => $_SESSION['compra'],
                    "id_usu"           => $usuario,
                    "correo"           => $emailUs,
                    "correo_cliente"   => $_SESSION['email'],
                    "estado"           => 2,
                    "telefono"         => intval($this->input()->post('telefono')),
                    "tipo_venta"       => "N/A",
                    "mensaje_webpay"   => "N/A",
                    "inicio"           => date("Y-m-d H:i:s",time()-3600)
                );

                #Se guarda la venta.
                $mysqlVenta = $this->ven->savevent($datosVenta);

                #Se verifica el registro en la base de datos
                if( !is_null($mysqlVenta) ){
                    #Guardamos el id de la venta en session.
                    $_SESSION["ventaid"] = $mysqlVenta;

                    setcookie("ventaidcook", intval($mysqlVenta));
                    #Se actualiza la tarjeta a estado proceso.
                    $updateCard = $this->ven->actualizartarjeta( $_SESSION['Tgr'], 2 );
                    #Verificar si se actualiza la tarjeta.
                    if($updateCard != false){
                        $result = array(
                            "data"    => 1,
                            "cod"     => $webpay
                        );

                        funciones::writeLog(1, "Iniciar compra", $webpay->order, $webpay->token_ws);
                    } else {
                        $result = array(
                            "data"    => 2,
                            "cod"     => $webpay
                        );
                        funciones::writeLog(2, "Error al reservar la tarjeta", $webpay->order, $webpay->token_ws);
                    }

                } else {
                    $result = array(
                        "data"    => 3,
                        "cod"     => $webpay
                    );
                    funciones::writeLog(3, "Error al guardar venta", $webpay->order, $webpay->token_ws);
                }
            } else {
                $result = array(
                    "data" => 5
                );
                funciones::writeLog(5, $webpay->error);
            }

        } else {
            $result = array(
                "data"    => 4,
            );
            funciones::writeLog(4, "Tarjeta no disponible");
        }

        print_r(json_encode(["data" => $result]));
    }

    function sendmsgcontact(){
        $data = $_POST;
        $mensaje = '<table>
            <tr>
                <td><strong>NOMBRE</strong></td>
                <td>'.$data["name"].'</td>
            </tr>
            <tr>
                <td><strong>EMAIL</strong></td>
                <td>'.$data["email"].'</td>
            </tr>
            <tr>
                <td><strong>WHATSAPP</strong></td>
                <td>'.$data["whatsapp"].'</td>
            </tr>
            <tr>
                <td><strong>MENSAJE</strong></td>
                <td>'.$data["mensaje"].'</td>
            </tr>
        </table>';

        $response = $this->email->config(
            Config::EmailSender["cuenta"],
            Config::EmailSender["pass"],
            'Sistema Locutorios: Mensaje de contacto',
            Config::EmailSender["cuenta"],
            Config::EmailSender["cuenta"],
            'Formulario de contacto',
            $mensaje,
            'este es un mensaje adicional');

        echo json_encode(["data" => $response]);
    }
}