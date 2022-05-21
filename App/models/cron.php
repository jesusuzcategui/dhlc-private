<?php namespace App\Models;

use Core\Database,
    PDO;

defined("BASEPATH") or die("ACCESS DENIED");

class cron 
{
    public $dbo;

    public function __construct()
    {
        $this->dbo = new Database;
    }

    public function testeo()
    {
        echo 'HOLA';
    }
}