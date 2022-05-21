<?php namespace App\Controllers;

use Core\Controller;
use Core\Model;
use Core\View;
use Core\Helpers;
use App\helpers\Ajax;

defined("BASEPATH") or die("ACCESS DENIED");

class targetas extends Controller
{
    private $mod;
    private $mdemcript;
    private $select;
    function __construct()
    {
        $this->mod       = Model::loadModel('targetas');
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
        View::render(__CLASS__, 'targetas', 'Gestion de Tarjetas');
    }

    

    function ajax($action=null)
    {
        if( $action != null ){
            //$Ajax = Helpers::loadHelper('Ajax');
            if(Ajax::isAjax()){
                switch ($action){
                    case 'gettar':
						$json = array();
                        foreach($this->mod->gettars() AS $targeta):
							$push = array(
								"id"=>$targeta['id'],
								"codigo"=> $targeta['cod_targ'],
                                "precio"=> $targeta['precio'],
                                "estado" =>$targeta['estado'],
								"creacion" =>$targeta['creacion'],
                                "accion" => '
												<button id="editdoc" title="editar usuario" type="button" onclick="javascript:modaleditOpen('.$targeta['id'].')" class="uk-button uk-button-segundary"><i class="fas fa-edit"></i></button>
												<button id="elidoc" title="eliminar usuario" type="button" onclick="javascript:modalDelete('.$targeta['id'].')" class="uk-button uk-button-danger"><i class="fa fa-trash"></i></button>
											</div>'
							);
							array_push($json, $push);
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
                    case 'savetar':
                     //Encripta información:
                      $headers =apache_request_headers();;	
                       $result1=$headers;     
                        $response=$this->mdemcript->verifitoken($headers['Permiso']);
                     //  print_r($response);
                           if($response[0]=="true"){

                                    $send=array(
                                        "cod_targ"=>$this->input()->post('codigo'),
                                        "precio"=>(int)$this->input()->post('precio'),
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
                                    $result = 3;
                                }
                                print_r( json_encode(["data" => $result1])); 
                                //print_r( json_encode($dato_desencriptado));
                         break;
                    case 'actualizartar':
                         //$dato = "Esta es información importante";
                         //Encripta información:
                        // $headers = apache_request_headers();				        
                        // $response=$this->mdemcript->verifitoken($headers['Permiso']);
                            //print_r($response);
                            // if($response[0]=="true"){
                                       
                                          
                                $send=array(
                                    "cod_targ"=>$this->input()->post('codigo'),
                                    "precio"=>(int)$this->input()->post('precio'),
                                    "estado_id"=>(int)$this->input()->post('estado'),
                                    "estatus_id"=>1,
                                    "creacion"=>date("Y-m-d H:i:s",time()-3600)
                                ); 
                                        
                                

                                if($this->mod->actualizartar($send,$this->input()->post('id'))!=null){
                                $result = 1;
                                }else{
                                $result = 2;
                                }
                         //}else{
                        //  $result = 3;
                        // }

                        print_r( json_encode(["data" => $result])); 
                        //print_r( json_encode($dato_desencriptado));
                         break;

                    case "deletetar":
                    ///$headers = apache_request_headers();				        
                    //$response=$this->mdemcript->verifitoken($headers['Permiso']);
                       //print_r($response);
                        //if($response[0]=="true"){

                            $send=array(
                                "estatus_id"=>2
                            );
                            if($this->mod->actualizartar($send,$this->input()->post('id'))!=null){
                                $result = 1;
                            }else{
                                $result = 2;
                            }
                       // }else{
                       //     $result = 3; 
                       // }

                            print_r( json_encode(["data" => $result]));
                   
                         break;
                }
            }
        }
    }
}

