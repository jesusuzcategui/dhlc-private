<?php namespace App\Controllers;

use Core\Controller;
use Core\Model;
use Core\View;
use Core\Helpers;
use App\helpers\Ajax;

defined("BASEPATH") or die("ACCESS DENIED");

class usuarios extends Controller
{
    private $modUser;
    private $mdemcript;
    private $select;
    function __construct()
    {
        $this->modUser = Model::loadModel('usuarios');
        $this->mdemcript = Helpers::loadHelper('Auth');
        $this->select    = Model::loadModel('selects');
       
        $this->verifySession('');
        
        $data=$this->select->selectper('listusu');
		 if($data=false||$data='false'){
         $this->verifySession('ref');
		}

		

    }

    function index()
    {
        View::render(__CLASS__, 'usuarios', 'Gestion de Usuarios');
    }

    function test()
    {
        View::render(__CLASS__, 'test', 'TESTING');
    }    

    function ajax($action=null)
    {
        if( $action != null ){
            //$Ajax = Helpers::loadHelper('Ajax');
            if(Ajax::isAjax()){
                switch ($action){
                    case 'testToken':
                    $headers = apache_request_headers();
                    print_r( json_encode($headers) );
                    break;
                    case 'listusuario':
                        $response = [];
                        if( $this->modUser->verifyEmail( $this->post('email') ) == false ){
                            $response = ["response" => 1];
                        } else {
                            if( $this->modUser->verifyUser(array(
                                    'email' => $this->post('email'),
                                    'contra' => $this->post('contra')
                                )) == false ){
                                $response = ["response" => 2];
                            } else {
                                $response = ["response" => 3];
                            }
                        }
                        print_r( json_encode( $response ) );
                        break;
                    case 'getUsu':
                        $json = array();
                        
                        foreach($this->modUser->getUsus() AS $usuario):
                            $data=$this->select->selectper('listusu');
		                   if($data=false||$data='false'){
							$push = array(
								"id"=>$usuario['id'],
								"cedula"=> $usuario['cedula'],
                                "email"=> $usuario['email'],
                                "telefono" =>$usuario['telefono'],
								"rol" =>$usuario['roll'],
                                "accion" => '<div id="botonstabla"class="uk-button-group">
												<button id="editdoc" title="editar usuario" type="button" onclick="javascript:modaleditOpen('.$usuario['id'].')" class="uk-button uk-button-segundary"><i class="fas fa-edit"></i></button>
												<button id="elidoc" title="eliminar usuario" type="button" onclick="javascript:modalDelete('.$usuario['id'].')" class="uk-button uk-button-danger"><i class="fa fa-trash"></i></button>
											</div>'
							);
                            array_push($json, $push);
                        }
                        endforeach;
                    
                        #Imprimimos el objeto json.
                        
						print_r(json_encode(["data"=>$json]));
                        break;

                    case 'usuid':
                        print_r( json_encode( $this->modUser->getUsus($this->input()->post('id'))) );
                       // print_r( json_encode($_POST['id']));
                        break;

                    case 'rolls':
                       print_r( json_encode( $this->modUser->getRoll()) );  
                         break;
                    case 'saveusu':
                     //Encripta información:
                      $headers =apache_request_headers();;	
                     // $result=$headers;     
                        $response=$this->mdemcript->verifitoken($headers['Permiso']);
                     //      print_r($response);
                           if($response[0]=="true"){

                            $data=$this->select->selectper('regusu');
                            if($data=false||$data='false'){

                           // $dato = "Esta es información importante";
                                //Encripta información:
                                   $dato=$this->input()->post('contrasena');
                                    $dato_encriptado =$this->mdemcript->encriptar($dato);
                               
                                    $send=array(
                                        "cedula"=>$this->input()->post('cedula'),
                                        "email"=>$this->input()->post('email'),
                                        "telefono"=>$this->input()->post('telefono'),
                                        "rol_id"=>(int)$this->input()->post('rol'),
                                        "contra"=>$dato_encriptado,
                                        "estatus_id"=>1
                                    );

                                    if($this->modUser->saveusu($send)!=null){
                                    $result = 1;
                                    }else{
                                    $result = 2;
                                    }
                                 }else{
                                    $result = 4;   
                                 }
                                }else{
                                   $result =3;
                                }
                                print_r( json_encode(["data" => $result])); 
                                //print_r( json_encode($dato_desencriptado));
                         break;
                    case 'actualizarusu':
                         //$dato = "Esta es información importante";
                         //Encripta información:
                         $headers = apache_request_headers();				        
                        $response=$this->mdemcript->verifitoken($headers['Permiso']);
                            //print_r($response);
                            if($response[0]=="true"){
                                $data=$this->select->selectper('editusu');
                                if($data=false||$data='false'){    
                                          
                                            $send=array(
                                                "cedula"=>$this->input()->post('cedula'),
                                                "email"=>$this->input()->post('email'),
                                                "telefono"=>$this->input()->post('telefono'),
                                                "rol_id"=>(int)$this->input()->post('rol'),
                                                "estatus_id"=>1
                                            );
                                     
                                        
                                

                                if($this->modUser->actualizarusu($send,$this->input()->post('id'))!=null){
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

                    case 'deleteusua':
                   $headers = apache_request_headers();				        
                    $response=$this->mdemcript->verifitoken($headers['Permiso']);
                      // print_r($response);eliusu

                      if($response[0]=="true"){
                        $data=$this->select->selectper('eliusu');
                        if($data=false||$data='false'){

                            $send=array(
                                "estatus_id"=>2
                            );
                            if($this->modUser->actualizarusu($send,$this->input()->post('id'))!=null){
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
                   
                         break;
                }
            }
        }
    }
}

