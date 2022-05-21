<?php namespace App\Controllers;

use Core\Controller;
use Core\Model;
use Core\View;
use Core\Helpers;
use Core\Config;
use \Core\Mail;
use App\helpers\Ajax;
use \Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\helpers\Functions as funciones;
use \stdClass;

defined("BASEPATH") or die("ACCESS DENIED");

class ventas extends Controller
{
    private $mod;
    private $mdemcript;
    private $select;
    private $transaction;
    private $validate;
    private $codigo;
    public  $email;
    public $direccioncorreo;
    private $excel;
	public $pdf;
	private $tarjetas;
    function __construct()
    {
        $this->mod       = Model::loadModel('ventas');
		$this->tarjetas  = Model::loadModel('tarjetas');
        $this->mdemcript = Helpers::loadHelper('Auth');
        $this->select    = Model::loadModel('selects');
        $this->excel     = new Spreadsheet;
		$this->pdf = new Dompdf;
        $this->email= new Mail();

        $this->verifySession('');

        $data=$this->select->selectper('listtar');
  		 if($data=false||$data='false'){
         $this->verifySession('ref');
       }

        $this->Email= new Mail();

    }

    function index()
    {
        View::render(__CLASS__,'ventas', 'Gestion de ventas');
    }
    
    function manual()
    {
        View::render(__CLASS__, 'ventamanual', 'Añadir venta');
    }

    function export()
    {
      $filterByState  = filter_input(INPUT_GET, 'byState');
      $filterByIni    = filter_input(INPUT_GET, 'byIni');
      $filterByFin    = filter_input(INPUT_GET, 'byFin');
      $filterByPrecio = filter_input(INPUT_GET, 'byPrecio');
      switch($filterByPrecio){
        case '1':
          $precio = 'CLP 1000 $';
          break;
        case '2':
          $precio = 'CLP 2000 $';
          break;
        case '3':
          $precio = 'CLP 5000 $';
          break;
        default:
          $precio = 'N/A';
          break;
      }

      switch($filterByState){
        case '1':
          $state = 'DISPONIBLE';
          break;
        case '2':
          $state = 'PROCESO';
          break;
        case '3':
          $state = 'PAGADA';
          break;
        case '4':
          $state = 'BLOQUEADA';
          break;
        case '5':
          $state = 'ELIMINADA';
          break;
        default:
          $state = 'N/A';
          break;
      }
      /*var_dump($filterByPrecio);
      var_dump($filterByState);
      var_dump($filterByIni);
      var_dump($filterByFin);*/
      $result         = $this->mod->filterVentas(null, $filterByState, $filterByIni, $filterByFin, $filterByPrecio);
     
      if($cantidad = count($result->data) > 0):
        $this->excel->getProperties()
                ->setCreator("LOCUTORIOS COMPRA PIN")
                ->setLastModifiedBy('Administrador.')
                ->setTitle('VENTAS')
                ->setDescription('Reporte de ventas');

        $hoja = $this->excel->getActiveSheet();

        $hoja->setTitle('Ventas');

        $headerA = ["CANT. CLP", "PINES 1000", "PINES 2000", "PINES 5000", "VEND. 1000", "VEND. 2000", "VEND. 5000"];

        $hoja->fromArray($headerA, null, 'A1');

        $hoja->setCellValueByColumnAndRow(1, 2, number_format($result->totalesVentas[0]['ventas_total_dinero'], 2, '.', ',') );
        $hoja->setCellValueByColumnAndRow(2, 2, number_format($result->totalesVentas[0]['ventas_total_mil'], 2, '.', ',') );
        $hoja->setCellValueByColumnAndRow(3, 2, number_format($result->totalesVentas[0]['ventas_total_dosmil'], 2, '.', ',') );
        $hoja->setCellValueByColumnAndRow(4, 2, number_format($result->totalesVentas[0]['ventas_total_cincomil'], 2, '.', ',') );
        $hoja->setCellValueByColumnAndRow(5, 2, $result->totalesVentas[0]['cant_tar_mil']);
        $hoja->setCellValueByColumnAndRow(6, 2, $result->totalesVentas[0]['cant_tar_dosmil'] );
        $hoja->setCellValueByColumnAndRow(7, 2, $result->totalesVentas[0]['cant_tar_cincomil'] );

        $header = ["ORDEN", "EMAIL", "PIN", "TELÉFONO", "MONTO", "FECHA", "ESTATUS"];

        $hoja->fromArray($header, null, 'A4');

        $ventas = $result->data;

        $fila = 5;

        foreach($ventas as $cli){
          $hoja->setCellValueByColumnAndRow(1, $fila, $cli['id_operacion']);
          $hoja->setCellValueByColumnAndRow(2, $fila, strtoupper($cli['correo_cliente']));
          $hoja->setCellValueByColumnAndRow(3, $fila, $cli['pin']);
          $hoja->setCellValueByColumnAndRow(4, $fila, $cli['telefono']);
          $hoja->setCellValueByColumnAndRow(5, $fila, $cli['precio']);
          $hoja->setCellValueByColumnAndRow(6, $fila, $cli['inicio']);
          $hoja->setCellValueByColumnAndRow(7, $fila, strtoupper($cli['estado']) );
          $fila++;
        }

        $nombreDelDocumento = 'Reporte de ventas - compra pin - ' . date('d-m-Y h:m:s') .'.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nombreDelDocumento . '"');
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($this->excel, 'Xlsx');
        $writer->save('php://output');
        exit;
      else:
        echo 'No se han hallado registros';
      endif;
      //print_r(json_encode($result->data));
    }

    function ajax($action=null)
    {
        if( $action != null ){
            //$Ajax = Helpers::loadHelper('Ajax');
            if(Ajax::isAjax()){
                switch ($action){
                    case 'detailSale':
                      if( $this->input()->is_post('itemId') ){

                        $venta = $this->mod->getvent( $this->input()->post('itemId') );

                        if(count($venta) > 0){
                          $data = array("data" => 1, "venta" => $venta[0]);
                        } else {
                          $data = array("data" => 3);
                        }

                      } else {
                        $data = array("data" => 2);
                      }

                      print_r(json_encode($data));
                    break;
                    case 'updateState':
                      #Se convierte la fecha a formato mysql
                      $fechaPost = strtotime($this->input()->post('fecha'));
                      $date = date('Y-m-d H:i:s', $fechaPost);
                      #Se prepará el array de datos a actualizar
                      $array = array(
                        "estado" => intval( $this->input()->post('estado') ),
                        "fin"    => $date
                      );
                      $itemId = intval($this->input()->post('itemId'));

                      $resultado = $this->mod->updateState($array, $itemId);

                      if($resultado == true){
                        $json = ["data"=>1];
                      } else {
                        $json = ["data"=>2];
                      }

                      print_r(json_encode($json));
                    break;
                    case 'getDataTable':
                      $json = array();

                      $datatable = $this->mod->getSaleForDataTable(
                        $_POST['search']['value'],
                        $_POST['length'],
                        $_POST['columns'][ $_POST['order'][0]['column'] ]['data'],
                        $_POST['order'][0]['dir'],
                        $_POST['start'],
                        $_POST['filterPrice'],
                        $_POST['filterState'],
                        $_POST['filterIni'],
                        $_POST['filterFin']
                      );

                      $registros = $datatable['data'];

                      foreach($registros AS $venta):
                        if($venta['estado']!='Pagada'){
                          $class = 'uk-disabled';
                        } else {
                          $class = '';
                        }
                        $push = array(
                          "id"=>$venta['id'],
                          "email"     => $venta['email'],
                          "correo"    => $venta['correo'],
                          "cliente"   => $venta['correo_cliente'],
                          "telefono"  => $venta['telefono'],
                          "tarjeta"   => $venta['cod_targ'],
                          "pin"       => $venta['pin'],
                          "precio"    => $venta['precio'],
                          "operacion" => $venta['id_operacion'],
                          "fecha"     => $venta['fecha'],
                          "estado"    => $venta['estado'],
                          "inicio"    => $venta['inicio'],
                          "final"     => $venta['fin'],
                          "accion"    => '<button class="uk-button uk-button-default" type="button"><span uk-icon="icon: more-vertical"></span></button>
                                          <div uk-dropdown="mode: click">
                                              <ul class="uk-nav uk-dropdown-nav">
                                                  <li class="uk-nav-header">Acciones</li>
                                                  <li class="uk-nav-divider"></li>
                                                  <li><a href="javascript:modaleditOpen('.$venta['id'].', '.$venta['estado_id'].', `'.$venta['fin'].'`)">Editar</a></li>
                                                  <li><a href="javascript:modalviewOpen('.$venta['id'].')">Detalle</a></li>
                                              </ul>
                                          </div>'
                        );
                        array_push($json, $push);
                      endforeach;

                      $response = array(
                        "draw" => intval($_POST['draw']),
                        "iTotalRecords" => $datatable['total'],
                        "iTotalDisplayRecords" => $datatable['totalD'],
                        "aaData" => $json
                      );
                      print_r(json_encode($response));
                    break;
                    case 'getvent':
						            $json = array();
                        foreach($this->mod->getvent() AS $venta):
                          if($venta['estado']!='Pagada'){
                            $class = 'uk-disabled';
                          } else {
                            $class = '';
                          }
            							$push = array(
            								"id"=>$venta['id'],
                            "email"     => $venta['email'],
                            "correo"    => $venta['correo'],
                            "cliente"   => $venta['correo_cliente'],
                            "telefono"  => $venta['telefono'],
                            "tarjeta"   => $venta['cod_targ'],
                            "precio"    => $venta['precio'],
                            "operacion" => $venta['id_operacion'],
                            "fecha"     => $venta['fecha'],
                            "estado"    => $venta['estado'],
                            "inicio"    => $venta['inicio'],
                            "final"     => $venta['fin'],
                            "accion"    => '<button class="uk-button uk-button-default" type="button"><span uk-icon="icon: more-vertical"></span></button>
                                            <div uk-dropdown="mode: click">
                                                <ul class="uk-nav uk-dropdown-nav">
                                                    <li class="uk-nav-header">Acciones</li>
                                                    <li class="uk-nav-divider"></li>
                                                    <li><a href="javascript:modaleditOpen('.$venta['id'].', '.$venta['estado_id'].', `'.$venta['fin'].'`)">Editar</a></li>
                                                    <li><a href="javascript:modalviewOpen('.$venta['id'].')">Detalle</a></li>
                                                </ul>
                                            </div>'
            							);
							            array_push($json, $push);
                        endforeach;

                        #Imprimimos el objeto json.

						print_r(json_encode(["data"=>$json]));
                        break;
                    case 'venedit':
                        print_r( json_encode( $this->mod->getvent($this->input()->post('id'))) );
                       // print_r( json_encode($_POST['id']));
                        break;

                    case 'estados':
                       print_r( json_encode( $this->mod->getestado()) );
                         break;

                    case 'totalventas':
                      $from   = $this->input()->get('from');
                      $to     = $this->input()->get('to');
                      print_r( json_encode( $this->mod->getTotalByFilter( $from, $to) ) );

                    break;
						
					case 'registermanual':
						
						$response = new stdClass;
						
						$tarjeta = $this->mod->verifitarventa( intval($_POST['venta']['precio']) );
						
						if( count($tarjeta) > 0 ){
							$updateTajeta = $this->mod->actualizartarjeta( $tarjeta[0]['id'], 3 );
							
							if($updateTajeta){
								$datosVenta=array(
									"id_targeta"       => intval($tarjeta[0]['id']),
									"id_estatus"       => 1,
									"fecha"            => date("Y-m-d H:i:s",time()-3600),
									"id_operacion"     => intval($_POST['venta']['orden']),
									"id_usu"           => 1,
									"correo"           => $_POST['venta']['email'],
									"correo_cliente"   => $_POST['venta']['email'],
									"estado"           => 3,
									"telefono"         => intval($_POST['venta']['telefono']),
									"tipo_venta"       => "N/A",
									"mensaje_webpay"   => "N/A",
									"inicio"           => date("Y-m-d H:i:s",time()-3600),
									"fin"              => date("Y-m-d H:i:s",time()-3600)
								);
								
								#Se guarda la venta.
									
								
								$mysqlVenta = $this->mod->savevent($datosVenta);
								
								//var_dump($mysqlVenta);
								#Se verifica el registro en la base de datos
								if( !is_null($mysqlVenta) ){
									$mensajeCorreo = funciones::getHTMLToEmail($_POST['venta']['orden'], $tarjeta[0]['targeta'], $tarjeta[0]['monto'], funciones::getLogoToEmail(2));
									
									$mensaje = $mensajeCorreo;
									
									#Enviando correo.
									
									$send    = $this->email->config("uzcateguijesusdev@gmail.com", "Guali#21", 'Sistema Locutorios', $_POST['venta']['email'], $_POST['venta']['email'],'Compra de PIN #'.$_POST['venta']['orden'], $mensaje, 'este es un mensaje adicional', null, null);
									
									$response->error = null;
								
								} else {
									$response->error = 3;
								}
							} else {
								$response->error = 2;
							}
						} else {
							$response->error = 1;
						}
						
						echo json_encode($response);
						
						
					break;
                }
            }
        }
    }
}
