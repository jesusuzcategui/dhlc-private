<?php namespace App\Controllers;

use Core\Controller;
use Core\SimpleXLSX;
use Core\Model;
use Core\View;
use Core\Helpers;
use App\helpers\Ajax;

defined("BASEPATH") or die("ACCESS DENIED");

class tarjetas extends Controller
{
    private $mod;
    private $mdemcript;
    private $select;
    private $Excel;
    function __construct()
    {
        $this->mod       = Model::loadModel('tarjetas');
        $this->mdemcript = Helpers::loadHelper('Auth');
        $this->select    = Model::loadModel('selects');
       
        $this->verifySession('');
        
        $data=$this->select->selectper('listtar');
		 if($data=false||$data='false'){
         $this->verifySession('ref');
		}

		

    }

    function index()
    {
        View::render(__CLASS__,'tarjetas', 'Gestion de Tarjetas');
    }

    function importar()
    {
        View::render(__CLASS__, 'importTarjetas', 'Carga masiva de tarjetas');
    }
    

    function ajax($action=null)
    {
        if( $action != null ){
            //$Ajax = Helpers::loadHelper('Ajax');
            if(Ajax::isAjax()){
                switch ($action){
					
					case 'querypin':
					
						$query = $_GET['query'];					
						$result = $this->mod->getPines($query);
						print_r( json_encode($result) );
					
					break;				
					
                    case 'import':
                        $this->Excel = new SimpleXLSX;
                        $this->Excel->skipEmptyRows = true; 
                        $fileX = $this->Excel->parseFile($_FILES['excel']['tmp_name']);
                        if($fileX != false){
                            $filas = $this->Excel->rows();
                            $estan = 0;
                            $errors = 0;
                            $registradas = 0;
                            $sinmonto = 0;
                            $tarjetas=$this->mod->addMultipleCard($filas);

                            for($i=0;$i<count($tarjetas);$i++){
                                
                                if($tarjetas[$i] === 1){
                                    $registradas = $registradas + 1;
                                } else if($tarjetas[$i] === 4){
                                    $estan = $estan + 1;
                                } else if( ($tarjetas[$i] === 2) || ($tarjetas[$i] === 5) ){
                                    $errors = $errors + 1;
                                } else if($tarjetas[$i] === 3){
                                    $sinmonto = $sinmonto + 1;
                                }
                                
                            }

                            $respuesta=array($registradas, $estan, $errors, $sinmonto);
                        } else {
                            $respuesta = false;
                        }
                    
                        print_r(json_encode($respuesta));                    
                    break;
                    case 'getDataTable':

                        $json = array();
  
                        $datatable = $this->mod->getCardsForDataTable(
                          $_POST['search']['value'],
                          $_POST['length'],
                          $_POST['columns'][ $_POST['order'][0]['column'] ]['data'],
                          $_POST['order'][0]['dir'],
                          $_POST['start'],
                          $_POST['filterPrice'],
                          $_POST['filterState']
                        );
  
                        $registros = $datatable['data'];
  
                        foreach($registros as $tarjeta):
                          $push = array(
                                  "check" => '<input class="uk-checkbox delete_check" type="checkbox" name="item_'.$tarjeta['id'].'" id="item_'.$tarjeta['id'].'" value="'.$tarjeta['id'].'">',
                  "id"=>$tarjeta['id'],
                  "codigo"=> $tarjeta['cod_targ'],
                                  "precio"=> $tarjeta['precio'],
                                  "pin"=> $tarjeta['pin'],
                                  "estado" =>$tarjeta['estado'],
                  "creacion" =>$tarjeta['creacion'],
                                  "accion" => '<div class="uk-button-group"><button id="editdoc" title="editar usuario" type="button" onclick="javascript:modaleditOpen('.$tarjeta['id'].')" class="uk-button uk-button-segundary"><i class="fas fa-edit"></i></button></div>'
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
                    case 'gettar':
						$json = array();
                        foreach($this->mod->gettars() AS $tarjeta):
                         $data=$this->select->selectper('listtar');
		                   if($data=false||$data='false'){
                            $push = array(
                                "check" => '<input type="checkbox" name="item_'.$tarjeta['id'].'" id="item_'.$tarjeta['id'].'" value="'.$tarjeta['id'].'">',
								"id"=>$tarjeta['id'],
								"codigo"=> $tarjeta['cod_targ'],
                                "precio"=> $tarjeta['precio'],
                                "pin"=> $tarjeta['pin'],
                                "estado" =>$tarjeta['estado'],
								"creacion" =>$tarjeta['creacion'],
                                "accion" => '
												<button id="editdoc" title="editar usuario" type="button" onclick="javascript:modaleditOpen('.$tarjeta['id'].')" class="uk-button uk-button-segundary"><i class="fas fa-edit"></i></button>
												<button id="elidoc" title="eliminar usuario" type="button" onclick="javascript:modalDelete('.$tarjeta['id'].')" class="uk-button uk-button-danger"><i class="fa fa-trash"></i></button>
											</div>'
							);
                            array_push($json, $push);
                        }
                        endforeach;
                    
                        #Imprimimos el objeto json.
                        
						print_r(json_encode(["data"=>$json]));
                        break;
                    case 'taredit':
                        print_r( json_encode( $this->mod->gettars($this->input()->post('id'))) );
                       // print_r( json_encode($_POST['id']));
                        break;

                    case 'estados':
                       print_r( json_encode( $this->mod->getestado()) );  
                         break;
                    case 'precio':
                         print_r( json_encode( $this->mod->getprecio()) );  
                           break;
                    case 'savetar':
                     //Encripta información:
                     $headers =apache_request_headers();;	
                     //  $result=$headers;     
                       $response=$this->mdemcript->verifitoken($headers['Permiso']);
                     //    print_r($response);
                          if($response[0]=="true"){
                               
                                $data=$this->select->selectper('regitar');
                        
                                if($data=false||$data='false'){
                                    $send=array(
                                        "cod_targ"=>$this->input()->post('codigo'),
                                        "pin"=>$this->input()->post('pin'),
                                        "precio"=>$this->input()->post('precio'),
                                        "estado_id"=>(int)$this->input()->post('estado'),
                                        "estatus_id"=>1,
                                        "creacion"=>date("Y-m-d H:i:s",time()-3600)
                                    );

                                    if($this->mod->savetar($send)!=null){
                                    $result = 1;
                                    }else{
                                    $result = 2;
                                    }
                                 }else{
                                    $result =4;
                                 } 
                              }else{
                                    $result =3;
                               }
                                print_r( json_encode(["data" => $result])); 
                                //print_r( json_encode($dato_desencriptado));
                         break;
                    case 'actualizartar':
                         //$dato = "Esta es información importante";
                         //Encripta información:
                        $headers = apache_request_headers();				        
                         $response=$this->mdemcript->verifitoken($headers['Permiso']);
                            //print_r($response);
                           if($response[0]=="true"){

                                $data=$this->select->selectper('acttarjeta');
                        
                                if($data=false||$data='false'){
                                       
                                          
                                $send=array(
                                    "cod_targ"=>$this->input()->post('codigo'),
                                    "pin"=>$this->input()->post('pin'),
                                    "precio"=>$this->input()->post('precio'),
                                    "estado_id"=>(int)$this->input()->post('estado'),
                                    "estatus_id"=>1,
                                    "creacion"=>date("Y-m-d H:i:s",time()-3600)
                                ); 
                                        
                                

                                if($this->mod->actualizartar($send,$this->input()->post('id'))!=null){
                                $result = 1;
                                }else{
                                $result = 2;
                                }
                           }else{
                                $result = 4;  
                            }
                         }else{
                         $result = 3;
                         }

                        print_r( json_encode(["data" => $result])); 
                        //print_r( json_encode($dato_desencriptado));
                         break;

                         case "deletetar":
                            $headers = apache_request_headers();
                            $response=$this->mdemcript->verifitoken($headers['Permiso']);
                            //print_r($response);
                            if($response[0]=="true"){
    
                            $data=$this->select->selectper('elitar');
    
                            if($data=false||$data='false'){
    
                                $eliminacion = $this->mod->dropMultipleCard($_POST['ids']);
    
                                if($eliminacion != false){
                                    if( is_int($eliminacion) ){
                                    $result = array("cant" => $eliminacion, "resp" => 1);
                                    }
                                } else {
                                    $result = array("cant" => null, "resp" => 2);;
                                }
    
                                }else{
                                $result = array("cant" => null, "resp" => 4);;
                                }
                            }else{
                                $result = array("cant" => null, "resp" => 3);;
                                }
                            print_r(json_encode(["data" => $result]));
                            break;
                            
                            case "updateStateTarjetaMasive":
                                $headers = apache_request_headers();
                                $response=$this->mdemcript->verifitoken($headers['Permiso']);
                                //print_r($response);
                                if($response[0]=="true"){
        
                                    $data=$this->select->selectper('elitar');
        
                                    if($data=false||$data='false'){
        
                                        $eliminacion = $this->mod->updateMasiveCard($_POST['ids'], $_POST['state']);
        
                                        if($eliminacion != false){
                                            if( is_int($eliminacion) ){
                                            $result = array("cant" => $eliminacion, "resp" => 1);
                                            }
                                        } else {
                                            $result = array("cant" => null, "resp" => 2);;
                                        }
        
                                    } else {
                                        $result = array("cant" => null, "resp" => 4);;
                                    }
                                } else {
                                    $result = array("cant" => null, "resp" => 3);;
                                }
                                print_r(json_encode(["data" => $result]));
                                break;
                }
            }
        }
    }
}