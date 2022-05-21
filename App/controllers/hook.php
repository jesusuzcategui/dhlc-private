<?php namespace App\Controllers;

use Core\Controller;
use Core\Model;
use Core\View;
use Core\Helpers;
use Core\Mail;
use Core\Config;
use App\helpers\Ajax;
use App\helpers\Functions as funciones;

use \stdClass;

defined("BASEPATH") or die("ACCESS DENIED");

class hook extends Controller {
  public $email;
  function __construct(){
    parent::__construct();
    $this->email= new Mail();
  }

  function index(){
    $this->email->config(
        Config::EmailSender["cuenta"],
        Config::EmailSender["pass"],
        'Sistema Locutorios: Error estado de Venta',
        'uzcateguijesusdev@gmail.com',
        'uzcateguijesusdev@gmail.com',
        'test',
        'MENSAJE DESDE TESTING', 'este es un mensaje adicional'
    );
  }
}
