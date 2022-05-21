<?php

namespace App\Controllers;

use Core\Controller;
use Core\Model;
use Core\View;

defined("BASEPATH") or die("ACCESS DENIED");

class ajustes extends Controller {

    public function __construct(){

    }

    public function index(){
        View::render(__CLASS__, 'ajustes', 'Ajustes globales');
    }

    public function updateSettings(){
        $name = $_POST["name"];
        $value = $_POST["value"];

    }


}