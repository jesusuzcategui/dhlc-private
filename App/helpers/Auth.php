<?php namespace App\helpers;

use \Firebase\JWT\JWT;
use \Firebase\JWT\ExpiredException;

defined("BASEPATH") or die("ACCESS DENIED");
 
class Auth
{
    
     private static $privateKey = <<<EOD
    -----BEGIN RSA PRIVATE KEY-----
    MIICXAIBAAKBgQC8kGa1pSjbSYZVebtTRBLxBz5H4i2p/llLCrEeQhta5kaQu/Rn
    vuER4W8oDH3+3iuIYW4VQAzyqFpwuzjkDI+17t5t0tyazyZ8JXw+KgXTxldMPEL9
    5+qVhgXvwtihXC1c5oGbRlEDvDF6Sa53rcFVsYJ4ehde/zUxo6UvS7UrBQIDAQAB
    AoGAb/MXV46XxCFRxNuB8LyAtmLDgi/xRnTAlMHjSACddwkyKem8//8eZtw9fzxz
    bWZ/1/doQOuHBGYZU8aDzzj59FZ78dyzNFoF91hbvZKkg+6wGyd/LrGVEB+Xre0J
    Nil0GReM2AHDNZUYRv+HYJPIOrB0CRczLQsgFJ8K6aAD6F0CQQDzbpjYdx10qgK1
    cP59UHiHjPZYC0loEsk7s+hUmT3QHerAQJMZWC11Qrn2N+ybwwNblDKv+s5qgMQ5
    5tNoQ9IfAkEAxkyffU6ythpg/H0Ixe1I2rd0GbF05biIzO/i77Det3n4YsJVlDck
    ZkcvY3SK2iRIL4c9yY6hlIhs+K9wXTtGWwJBAO9Dskl48mO7woPR9uD22jDpNSwe
    k90OMepTjzSvlhjbfuPN1IdhqvSJTDychRwn1kIJ7LQZgQ8fVz9OCFZ/6qMCQGOb
    qaGwHmUK6xzpUbbacnYrIM6nLSkXgOAwv7XXCojvY614ILTK3iXiLBOxPu5Eu13k
    eUz9sHyD6vkgZzjtxXECQAkp4Xerf5TGfQXGXhxIX52yH+N2LtujCdkQZjXAsGdm
    B2zNzvrlgRmgBrklMTrMYgm1NPcW+bRLGcwgW2PTvNM=
    -----END RSA PRIVATE KEY-----
EOD;

        private static  $publicKey ="jeyswadf";

        private static $encrypt = array('HS256');

        private static $aud = null;
       //Configuración del algoritmo de encriptación
       //Debes cambiar esta cadena, debe ser larga y unica
       //nadie mas debe conocerla
        private static $clave = 'gbthghfrjhtmjngvdfhmnmbngkkmghmbhjhkyukhmhghgkiyukmjmghkmyjkjmhjmhjmyjmhthjhvcvcghtggtrhg .edrfgebgth-nvnbgnbg ncvbxfhvbcvbcv2342r533!';
        //Metodo de encriptación
        private static $method = 'aes-256-cbc';
        // Puedes generar una diferente usando la funcion $getIV()
        private static $data="desftereetgefrvfgbgtdfgfrgervfedcrf";
        //metodo de codificacion
        private static $iv;
        public function  __construct(){
            self::$iv = base64_decode("enxzJpJwE25ZseZX/yb3LQ==");
        }


        function loadJWT(){
            $time=time();

            $token = array(
                "iat" => $time,
                "exp" => $time +(60*1000),
                "data"=>[
                   "email" => $_SESSION["email"]
                ]
            );
                    
            $JWT = JWT::encode($token,self::$privateKey);
        //  $data = JWT::decode($JWT, self::$publicKey, array('HS256'));
            
            return $JWT;
        }

        public static function verifitoken($token){
                    //$data = JWT::decode($token, self::$publicKey, array('HS256'));

                    //return $data;
            
            try{
                JWT::$leeway = 60;
                $decoded = JWT::decode( $token,
                                        self::$privateKey,
                                        self::$encrypt);
                return (["true",'token valido']);	
                }catch(\Exception $e){
                return (["false",$e->getMessage()]);
                }
        }

      
        public static function encriptar($valor){
            return openssl_encrypt ($valor, self::$method,self::$clave,false,self::$iv);
        }

        public static function desencriptar($valor){
            $encrypted_data = base64_decode($valor);
            return openssl_decrypt($valor, self::$method, self::$clave, false,self::$iv);
        }
        public static function getIV(){
            return base64_encode(openssl_random_pseudo_bytes(openssl_cipher_iv_length(self::$method)));
        }

}