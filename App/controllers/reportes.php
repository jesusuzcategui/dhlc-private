<?php namespace App\Controllers;

defined("BASEPATH") or die("ACCESS DENIED");

use \Core\Controller; // Controller master.
use \Dompdf\Dompdf;  //  DOMPDF

class reportes extends Controller
{
	public $pdf;

	public function __construct()
	{
		//$this->verifySession();

		$this->pdf = new Dompdf;


	}

	public function index()
	{
		$this->pdf->loadHtml('<h2>Hola mundo</h2>');
		$this->pdf->render();
		$this->pdf->stream();
	}


	public function locutorios($type=null)
	{
		if($type != null){
			switch ($type) {
				case 'recargas':
				$reporte = \Core\Helpers::loadHelper('reportes');
				$reporte::render('ventas.php','Registro de recargas');
				break;
				case 'usuarios':
				$reporte = \Core\Helpers::loadHelper('reportes');
				$reporte::render('usuarios.php', 'Listado de usuarios');
				break;
				case 'cards':
				$reporte = \Core\Helpers::loadHelper('reportes');
				$reporte::render('tarjetas.php', 'Listado de tarjetas');
				break;
			}
		} else {

		}
	}

	

	public function reporteconvista()
	{
		$reporte = \Core\Helpers::loadHelper('reportes');
		$reporte::render('usuarios.php');
	}

	/**
	 * Este método será el punto de entrada para todas las peticiones ajax de este controlador.
	 * Mediante una variable GET llamada "action" varidaremos que operación ejecutaremos.
	 * @method async
	 * @access  public
	 **/

	public function async()
	{
	}
}
