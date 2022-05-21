<?php

namespace App\Controllers;

use Core\Controller;
use Core\Model;
use Core\View;
use Core\Files;
use Core\Assets;
use App\helpers\Ajax;
use App\helpers\Functions;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

defined("BASEPATH") or die("ACCESS DENIED");

class dashboard extends Controller
{
  private $modVentas;
  private $files;
  private $model;
  private $excel;

  function __construct()
  {
    $this->files = new Files('upload/'); 
    $this->modVentas = Model::loadModel('ventas');
    $this->model = Model::loadModel("dashboard");
    $this->verifySession('');
    $this->excel     = new Spreadsheet;
  }

  function index()
  {
    View::render(__CLASS__, 'dashboard', 'Panel de administración');
  }

  function remarketing()
  {
    $resultado = $this->modVentas->getDataSales();
    View::set('emails', $resultado);
    View::render(__CLASS__, 'remarketing', 'REPORTE DE EMAILS');
  }

  function banners()
  {
    View::render(__CLASS__, 'bannersetting', 'Administrar Banners');
  }
  
  function clientsnosales(){
    View::render(__CLASS__, 'clientsnotsales', 'Administrar Clientes no compradores');  
  }

  function listBanner() {
    $list = $this->model->listBanner();
    echo json_encode($list);
  }

  function getBanner(){
    $id = $_GET["id"];
    if( empty($id) ){
      echo json_encode([]);
      exit();
    }

    $banner = $this->model->getBanner($id);

    echo json_encode($banner);
  }

  function updateSettingsBanner(){
    $id = $_POST["id"];
    $url = $_POST["url"];
    $position = $_POST["position"];

    if( empty($id) == true || empty($url) == true || empty($position) == true ){
      http_response_code(400);
      echo json_encode(["message" => "Error on save"]);
      exit();
    }

    if( $position == "null" ){
      $position = null;
    }

    $response = $this->model->updateBannerSettings($id, $position, $url);

    echo json_encode($response);
  }
  
  function getClientsNoSales(){
      $init = $_GET['init'];
      $ended = $_GET['ended'];
      
      if(empty($init) || empty($ended)){
          echo json_encode([]);
          exit();
      }
      
      $emails = $this->modVentas->getClientsFromNotSales($init, $ended);
      
      echo json_encode($emails);
      exit();
      
  }
  
  function exportClientsNotSales(){
      $init = $_GET['init'];
      $ended = $_GET['ended'];
      
      if(empty($init) || empty($ended)){
          echo json_encode([]);
          exit();
      }
      
      $emails = $this->modVentas->getClientsFromNotSales($init, $ended);
      
      if(count($emails) > 0){
          
        $this->excel->getProperties()->setCreator("LOCUTORIOS COMPRA PIN")->setLastModifiedBy('Administrador.')->setTitle('USUARIOS QUE NO HAN COMPRADO')->setDescription('REPORTES DE USUARIOS');

        $hoja = $this->excel->getActiveSheet();

        $hoja->setTitle('Emails');

        $headerA = ["Correo electronico", "Telefono"];

        $hoja->fromArray($headerA, null, 'A1');
        
        $fila = 3;

        foreach($emails as $cli){
          $hoja->setCellValueByColumnAndRow(1, $fila, $cli->correo);
          $hoja->setCellValueByColumnAndRow(2, $fila, $cli->telefono);
          $fila++;
        }
        
        $nombreDelDocumento = 'Reporte Usuarios no comprantes del ' . $init . ' - ' . $ended .'.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nombreDelDocumento . '"');
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($this->excel, 'Xlsx');
        $writer->save('php://output');
        exit;
        
          
      } else {
          echo 'No hay registros';
      }
      
  }

  function updateState(){
    $estado = $_POST['estado'];
    $id = $_POST['id'];
    $response = $this->model->toggleStateBanner($id, $estado);
    echo json_encode([$response]);
  }

  function uploadBanner(){
    if(!empty($_FILES['banner'])){
      $image = $this->files->verify($_FILES['banner']);
      $link  = $this->files->send($image);

      if( is_string($link) ){
        $response = $this->model->savedBanner($link, null);
        http_response_code(200);
        echo json_encode(["link" => $link, "insert" => $response]);
        exit;
      } else {
        http_response_code(400);
        echo json_encode(["link" => null]);
        exit;
      }
    }
  }
  
  function uploadBannerMovil(){
      if(!empty($_FILES['banner'])){
      $image = $this->files->verify($_FILES['banner']);
      $link  = $this->files->send($image);

      if( is_string($link) ){
        $response = $this->model->savedMovil($_POST['id'], $link);
        http_response_code(200);
        echo json_encode(["link" => $link, "insert" => $response]);
        exit;
      } else {
        http_response_code(400);
        echo json_encode(["link" => null]);
        exit;
      }
    }
  }

  function deleteBanner(){
    $id = $_REQUEST['id'];
    $resp = $this->model->deleteBanner($id);
    echo json_encode([$resp]);
  }

  function systemlog()
  {
    $logfile = BASEPATH . SPR . 'webpay.log';

    if (is_file($logfile)) {
      $contentLog = file_get_contents($logfile);
    } else {
      $contentLog = "El archivo no puede ser leido";
    }

    View::set('contenido', $contentLog);
    View::render(__CLASS__, 'systemlog', 'Log de acciones webpay');
  }
}
