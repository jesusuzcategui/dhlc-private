<?php namespace App\helpers;
use Transbank\Webpay\Configuration;
use Transbank\Webpay\Webpay;


defined("BASEPATH") or die("ACCESS DENIED");
 
class webpagos
{  
    private $configuration;
    public  $transaction;

    function __construct()
    {  
       $configuration = new Configuration();
        $configuration->setCommerceCode("34919305");

        $configuration->setPrivateKey(
            "-----BEGIN RSA PRIVATE KEY-----\n".
            "MIIEowIBAAKCAQEAl+0HT6Y17SYMKLMpBgq9YDLs7CP1sD6QU6jfhSdvKmUTjhpE\n".
            "E9w+A3HTsEqYtOb/8lp+VdOTS+abpldwcUpGonfRYDyrTkEBouTcZODfpRH+9Whd\n".
            "wlxyKdJlSu+0vmEtK77fTPwN5nobIgyNBnpZ7VX0V9mb32QkdqKvtNumnzy3zeU2\n".
            "vbp9Z/6wqCLNM7KFysKrR2YZ1Cg9Fon/sJcY+uAeJJB7+h0P/lMyA/v8chIkTyjo\n".
            "Pv6X68FI/rnzpeDf4eZ1UzMFrDNDrEjsMUkaHTJR/NPJjhpNxHVG+YeGQkQIP/5Y\n".
            "EGqzCTh7BNE8+XgaMg5mQmUxnvLnJtzrrx1G+wIDAQABAoIBAGZuPxGqhI1Bq8z9\n".
            "DlmugAQOEcMcc5fCdtiQ8TL7ZW31+/tBJkklowH7irg/czn0zPf/n1IKdjMkZij+\n".
            "pyca5wi/NAFopi76kTnch+PT4bWPrpCTLzPN1ILyAa1GdFwvdJ8b774d6tlL1mNc\n".
            "hvCpKVxlKXrZkshI4nTCNyj/NxYAdhPNBxYy8oQe6oi92on4/uDsd379lBRlqwb7\n".
            "1m4SfD2w9O6gEc7laE7Zp5YyrXj+ZQsAU+g38cN/6+2RRC9DqLYRrfQhQviWYzB2\n".
            "FyEIjSzHSmYEyTMdosS7WKTwlDla6BoBJ2KbzaO5HhkkNXeNFd44jYg7wsonKh1M\n".
            "t+D2bSECgYEAxr+EWnX7j+XcsFIRjhz4x9Qpj8+U6q8VA/SIn+9WSYAd52ipFPa4\n".
            "HIdUv4bwIQ8JXfguJvIH6BaKps42mdIpFZGdQixRchp61nOgx2I7S3Ec8ClKHY11\n".
            "csknpi93ZMn52peNcds7DorMGDICZZtT1S6p2CFgfLnhd+gwkrP6lWkCgYEAw7Cn\n".
            "ObmyJ4IxrNzZewULwKnhvwP11C8ceSY60OrzaqIu/hXxkte81ZdPtP1CV76ZOQv3\n".
            "aaORjWMFh5CN0NOLhtGWVj1UmRXvp0ToqilVQ/arNjQuZxHbpCXl1PoqrqmZXqHu\n".
            "52oKdQvXzVVKrA41bxFgVrybMpVntm9by//KuMMCgYEAtL/kTKjUGfBAnpJkqMws\n".
            "bP/EtKdilXSZNjmkL1/pJ3s+tv/2FbyzgC6LoovDwyz7pdxZjM285xPpEP6lpYr+\n".
            "FkGRtWa8w3rVkEckR3BM4LWETd4fK3VFBRlv17F/cchGVMhTuOJaeUU9jBufFm0G\n".
            "9vAzQv5H0+bw6K3fzuujz1ECgYAObluWrTQPJ9HD/rFnGhMozR5huMgLMsI1yPTz\n".
            "bTAwP++ZO0MKYjCBy9vL7BVVZS/lfhVry+0y8Qd6XNWofcE/WvtsNq+jbnOy8Sj7\n".
            "S3sHPQyZPbXiUfXRoB3X2+8D3Gv8B5MXq8FDqnDqqoyMLawRGcXx/4yuaUgxsvqh\n".
            "C6cGgwKBgGyeetRS+TMf68VH8jzSdGTVfBzpxSgDiSv2BzsWa0Aq8meKVZMpKMNT\n".
            "o4wTXz9HC99eZ1V+SRuou0L8YLeDi7/rj3wSJGfm844U7VzWIy5LXgMs07E5705l\n".
            "LWnH9w5rFGDTx2f86n1xrPT5yuUINnuAlKWNTeQzO3JsnBf3O+2s\n".
            "-----END RSA PRIVATE KEY-----"
        );

        $configuration->setPublicCert(
            "-----BEGIN CERTIFICATE-----\n".
            "MIIDPzCCAicCFAtv5d1R1/wT01+I0l6cM04cYqKpMA0GCSqGSIb3DQEBCwUAMFwx\n".
            "CzAJBgNVBAYTAkFVMRMwEQYDVQQIDApTb21lLVN0YXRlMSEwHwYDVQQKDBhJbnRl\n".
            "cm5ldCBXaWRnaXRzIFB0eSBMdGQxFTATBgNVBAMMDDU5NzAzNDkxOTMwNTAeFw0x\n".
            "OTExMjIwMTU3MzhaFw0yMzExMjEwMTU3MzhaMFwxCzAJBgNVBAYTAkFVMRMwEQYD\n".
            "VQQIDApTb21lLVN0YXRlMSEwHwYDVQQKDBhJbnRlcm5ldCBXaWRnaXRzIFB0eSBM\n".
            "dGQxFTATBgNVBAMMDDU5NzAzNDkxOTMwNTCCASIwDQYJKoZIhvcNAQEBBQADggEP\n".
            "ADCCAQoCggEBAJftB0+mNe0mDCizKQYKvWAy7Owj9bA+kFOo34UnbyplE44aRBPc\n".
            "PgNx07BKmLTm//JaflXTk0vmm6ZXcHFKRqJ30WA8q05BAaLk3GTg36UR/vVoXcJc\n".
            "cinSZUrvtL5hLSu+30z8DeZ6GyIMjQZ6We1V9FfZm99kJHair7Tbpp88t83lNr26\n".
            "fWf+sKgizTOyhcrCq0dmGdQoPRaJ/7CXGPrgHiSQe/odD/5TMgP7/HISJE8o6D7+\n".
            "l+vBSP6586Xg3+HmdVMzBawzQ6xI7DFJGh0yUfzTyY4aTcR1RvmHhkJECD/+WBBq\n".
            "swk4ewTRPPl4GjIOZkJlMZ7y5ybc668dRvsCAwEAATANBgkqhkiG9w0BAQsFAAOC\n".
            "AQEAHcAowoLLJZSqZ5/r+8y97oz4mb7gTtzb6l7AuTv5t+2EqfhPEBdPsW9vhxnJ\n".
            "Ki4U3NX92PxER+NQmJ3PAQyTElriQ1RGdd5UQErcCO7Wm9mKMu5b8yqRD8gCdjMI\n".
            "4ZMiZjC066ysl4TmhefPW/TdiamXo6uIJ2za0su6XYpelMCZ/mglD7xJ5GQkkG8D\n".
            "NupOWJzXa4663ZANtNEDNYHIWP4YubcG7pJ86znImn226pZ/yOn2W+/XOjKnPZvt\n".
            "SNb5FH83ivXrOdnDET80LEWk0QNICLcdGL6ZzF1AARG1AzadMsggN3or0MDPujhl\n".
            "3D97QD3EEhRZtM+794alKJ2Rjw==\n".
            "-----END CERTIFICATE-----"
        );

        //$configuration->setEnvironment("PRODUCCION");

        $webpay = new Webpay($configuration);
        $this->transaction =$webpay->getNormalTransaction();

       /* $this->transaction = (new Webpay(Configuration::forTestingWebpayPlusNormal()))
               ->getNormalTransaction();*/

    }

    function  pagos($amount,$return,$final){
        $amount =$amount;
        // Identificador que será retornado en el callback de resultado:
        $sessionId = session_id();
        // Identificador único de orden de compra:
        $buyOrder = strval(rand(100000, 999999999));
        $returnUrl = $return;
        $finalUrl = $final;
        $initResult = $this->transaction->initTransaction(
                $amount, $buyOrder, $sessionId, $returnUrl, $finalUrl);

       $formAction = $initResult->url;
        $tokenWs = $initResult->token;
        
        $data=array(
            "formAction"=>$formAction,
            "tokenWs"=>$tokenWs,
            "buyOrder"=>$buyOrder,
        );

        return $data;
    }

    public function return($token){
        return $result=$this->transaction->getTransactionResult($token);
    }

}
?>