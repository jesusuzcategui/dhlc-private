<?php namespace App\Controllers;

defined("BASEPATH") or die("ACCESS DENIED");

use \Core\Controller,
	\Core\Files,
    \Core\Mail,
    \Core\Config,
    App\helpers\Functions,
    App\helpers\Auth;

class restablecer extends Controller
{
	public $Email;
    public  $selectMod;
    private $Auth;
	
    public function __construct()
	{
		
		 $this->usuariosMod  = \Core\Model::loadModel('usuarios');
         $this->Email        = new Mail();
         $this->Auth         = new Auth;
    }

    public function index()
	{
        #Metodo render:
		\Core\View::render(__CLASS__, 'restablecer', 'Recuperar contrasena');

    }
    
    public function ajax($endpoint=null)
    {
        if(!is_null($endpoint)):
            
            switch($endpoint):
                case 'changepass':

                    $contra = $this->post('contra');
                    $email  = $this->post('email');
                    
                    if( $this->usuariosMod->updatePassword($email, Auth::encriptar($contra)) > 0 ):
                        $response = ["data" => true];
                    else:
                        $response = ["data" => false];
                    endif;

                    print_r(json_encode($response));

                break;
                case 'restorepass':
                    $email = $this->post('email');
                    $usaurio = $this->usuariosMod->getDatoUsuario('email', $email);
                    if( count($usaurio) > 0 ):
                        $contra =  Functions::genetarePass();
                        if( $this->usuariosMod->updatePassword($email, $contra['encrypt']) > 0 ):
                            $emailTxt = '
                            <div style="background: #2d2d2d; color: #f2f2f2; font-family: sans-serif; width: 500px; margin: auto; padding: 30px;">
                                <h2 style="text-align:center">SISTEMA DE TARJETAS LOCUTORIOS</h2>
                                <p>El sistema genero automaticamente una nueva clave, la cual es: <strong>'.$contra['decript'].'</strong></p>
                            </div>
                            ';
                            $send=$this->Email->config(Config::EmailSender["cuenta"], Config::EmailSender["pass"], 'Sistema Locutorios', $email, $email, 'RECUPERAIÓN DE CLAVE', $emailTxt, 'este es un mensaje adicional');
                            $response = ["data" => 1];
                        else:
                            $response = ["data" => 2];
                        endif;
                    else:
                        $response = ["data" => 3];
                    endif;

                    print_r(json_encode($response));
                break;
            endswitch;

        endif;
    }
}