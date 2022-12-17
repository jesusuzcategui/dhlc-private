<?php namespace Core;
defined("BASEPATH") or die("Access denied");

use Core\View, //Render views
    Core\Assets, // Assets classS
	Core\Model, //Load Models
	Core\Helpers,
  	App\helpers\Functions,
    Core\App; // Load Helpers

class Controller
{
	public $input;
	public $title;

  public function __construct(){
    
  }

	public function input()
	{
		return $this;
	}

	public function post($name, $default=null)
	{
		if(isset($_POST[$name])):
      if( is_array($_POST[$name]) ):
        return $_POST[$name];
      else:
        return trim($_POST[$name]);
      endif;
    else:
      //throw new \Exception("Does exists a object by POST method request has been called {$name}", 1);
      return $default;
    endif;
	}

	public function get($name, $default=null)
	{
		if(isset($_GET[$name])):
            if( is_array($_GET[$name]) ):
                return $_GET[$name];
            else:
                return trim($_GET[$name]);
            endif;
		else:
			//throw new \Exception("Does exists a object by GET method request has been called {$name}", 1);
      return $default;
		endif;
	}

	public function is_get($name)
	{
		return isset($_GET[$name]);
	}

	public function is_post($name)
	{
		return isset($_POST[$name]);
	}

  public function verifySession($data)
  {
    if(!isset($_SESSION['email']) && !isset($_SESSION['rol'])){
      session_unset();
      session_destroy();
      header('location: ' . Functions::permalink() . 'administrator?error=Sin%20Acceso' );
		} else if(is_array($data)){
      header('location:./error/nofound');
    }
  }

  public function response($data, $http = 200){
    http_response_code($http);
    echo json_encode($data);
  }


  public function verifyTimePay()
  {

    if( isset( $_SESSION['tiempoIni'] ) ){
      $wait = 600;
      $vida = time() - $wait;
      $vidainutos = floor(($vida / 60) % 60);
      echo sprintf("1) Quedan %d minutos", $vidainutos);
      if($vida > $wait){
        if(!isset($_GET['errorTime'])){
          header("Location: " . Functions::permalink() .'?errorTime=1' );
        } else {
          header("Location: " . Functions::permalink() );
        }
        unset($_SESSION['tiempoIni']);
        exit();
      } else {
        $_SESSION['tiempoIni'] = time();
        echo sprintf("2) Quedan %d minutos", $vidainutos);
      }
    } else {
      $_SESSION['tiempoIni'] = time();
      echo sprintf("3) Quedan %d minutos", floor(($_SESSION['tiempoIni'] / 60) % 60));
    }

  }
}
