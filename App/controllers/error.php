<?php namespace App\Controllers;
defined('BASEPATH') or die('ACCESS DENIED');
use Core\Controller; // Controller master.
use Core\View;       //Manage Views

class error extends Controller
{

  public function __construct()
  {

  }

  public function nofound()
  {
    View::viewError('404');
  }

  public function withoutaccess()
  {
    View::viewError('sinlogin');
  }

}
