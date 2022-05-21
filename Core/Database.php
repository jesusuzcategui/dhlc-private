<?php namespace Core;
defined("BASEPATH") or die("Access denied");

USE Core\Medoo,
	Core\Helpers,
	App\helpers\Functions,
	Core\Jdev,
	Core\Config,
	\PDO;

class Database extends Medoo
{
	private $_dbUser;
	private $_dbPass;
	private $_dbName;
	private $_dbHost;
	private $_dbPort;
	private $_dbType;
	public  $_conexion;

	public function __construct()
	{
		

		if( Functions::isLocal() ){
            $db = Config::AppDbLocal;
        } else {
            $db = Config::AppDbRemote;
        }
		
		if(count($db)>0):
			$this->_dbUser = isset($db["USER"]) ? $db["USER"] : null;
			$this->_dbType = isset($db['TYPE']) ? $db['TYPE'] : null;
			$this->_dbPort = isset($db['PORT']) ? $db['PORT'] : null;
			$this->_dbHost = isset($db['HOST']) ? $db['HOST'] : null;
			$this->_dbName = isset($db['NAME']) ? $db['NAME'] : null;
			$this->_dbPass = isset($db['PASS']) ? $db['PASS'] : null;
		else:
			throw new \Exception('The data on file /Core/Config.php does it correct, please verify', 1);
			exit;
		endif;

		$this->_conexion = parent::__construct([
			// required
			'database_type' => $this->_dbType,
			'database_name' => $this->_dbName,
			'server' => $this->_dbHost,
			'username' => $this->_dbUser,
			'password' => $this->_dbPass,
		 
			// [optional]
			'charset' => 'utf8mb4',
			'collation' => 'utf8mb4_general_ci',
			'port' => $this->_dbPort
		]);

		return $this->_conexion;
	}
}