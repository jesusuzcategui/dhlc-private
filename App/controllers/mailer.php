<?php namespace App\Controllers;

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

class mailer extends Controller
{
    public $email;
    public $pdf;
    public $templates;

    function __construct()
    {
        parent::__construct();
        $this->email = new Mail();
        $this->pdf = new Dompdf();
        $this->templates = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'emailWebpay.php';
    }
    
    function index(){
        if(is_file($this->templates)){
            ob_start();
            require_once($this->templates);
            $html = ob_get_clean();
            $send = $this->email->config(
                Config::EmailSender["cuenta"],
                Config::EmailSender["pass"],
                'Sistema Locutorios: Error estado de Venta',
                'uzcateguijesusdev@gmail.com',
                'uzcateguijesusdev@gmail.com',
                'Compra #'.$_SESSION["ventaid"].' - Sistema Pines Locutorios',
                $html, 'este es un mensaje adicional'
            );
            var_dump($send);
        }
    }
}