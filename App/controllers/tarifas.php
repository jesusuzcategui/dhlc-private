<?php namespace App\Controllers;

use Core\Controller;
use Core\Model;
use Core\View;
use Core\Helpers;
use App\helpers\Ajax;

defined("BASEPATH") or die("ACCESS DENIED");

class tarifas extends Controller 
{

	function __construct(){

	}

	function index(){

		echo 'tarifas';

	}

	function ajax($a=null){

		if( $a != null && Ajax::isAjax() ){

			switch($a){
				case 'uploadExcel':
				break;
			}

		}

	}

}