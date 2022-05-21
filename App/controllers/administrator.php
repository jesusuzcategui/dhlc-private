<?php namespace App\Controllers;

use Core\Controller;
use Core\Model;
use Core\View;
use Core\Helpers;
use Core\Config;
use Core\Mail;
use App\helpers\Ajax;
use App\helpers\Functions;

defined("BASEPATH") or die("ACCESS DENIED");

class administrator extends Controller
{
    private $mod;
    private $mdemcript;
    private $select;

    function __construct()
    {
        parent::__construct();
        $this->Email = new Mail;

    }

    function index()
    {
        //$this->verifySession();
        //View::render(__CLASS__, 'administrator', 'Ingresar a Locutorios tarjetas');
        /*if( !isset($_SESSION['email']) && !isset($_SESSION['rol']) ):
            View::render(__CLASS__, 'administrator', 'Ingresar a Locutorios tarjetas');
        else:
            header('Location: ' . Functions::permalink() . 'dashboard');
        endif;*/

        View::render(__CLASS__, 'administrator', 'Ingresar a Locutorios tarjetas');
    }
}
