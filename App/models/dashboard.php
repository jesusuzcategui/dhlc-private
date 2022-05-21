<?php namespace App\Models;

use Core\Database,
    PDO;

defined("BASEPATH") or die("ACCESS DENIED");

class dashboard {

    private $db;

    function __construct()
    {
        $this->db = new Database();
       
    }

    function get($id=null)
    {
        if( $id==null ){
            return $this->db->select('usuarios', '*');
        } else {
            return $this->db->select('usuarios', '*', [
                'id' => $id
            ]);
        }
    }

    function savedBanner($url, $link=null){
        return $this->db->insert("settings_banner", [
            "link_related" => (!$link) ? "#" : $link,
            "image_url" => $url
        ]);
    }
    
    function savedMovil($id, $link){
        return $this->db->update("settings_banner", ["image_movil" => $link], ["id" => $id]);
    }

    function listBanner(){
        return $this->db->select("settings_banner", '*');
    }

    function getBanner($id){
        return $this->db->select("settings_banner", "*", ["id" => $id]);
    }
    
    function findAviableBanner(){
        return $this->db->select("settings_banner", ["position", "link_related", "image_url", "image_movil"], [
            "state" => 1,
            "ORDER" => [
                "position" => "ASC"
            ]
        ]);
    }

    function updateBannerSettings($id, $position, $url){
        return $this->db->update( "settings_banner", ["position" => $position, "link_related"=> $url], ["id" => $id] );
    }

    function toggleStateBanner($id, $state){
        $estado = 0;
        if( $state == "1" ){
            $estado = 0;
        } else {
            $estado = 1;
        }

        return $this->db->update("settings_banner", ["state" => $estado], ["id" => $id]);
    }

    function deleteBanner($id){
        return $this->db->delete('settings_banner', ["id" => $id]);
    }

}