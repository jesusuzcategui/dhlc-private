<?php namespace App\helpers;

use Core\Config AS AppConfig;
use Transbank\Webpay\Configuration AS ConfigWebpay;
use Transbank\Webpay\Webpay;

defined("BASEPATH") or die("ACCESS DENIED");
 
class webpayhelper
{
    public $transaccion;
	public $ammount;
	public $order;
	public $return;
	public $finish;
	public $session;
	public $token;
    private $config;

	function __construct($mode=false){
		$this->ammount = null;
		$this->order = null;
		$this->return = null;
		$this->finish = null;
		$this->session = null;
		$this->token = null;
        
        if( !$mode ){
            
            $this->transaccion = (new Webpay(ConfigWebpay::forTestingWebpayPlusNormal()))->getNormalTransaction();   
        } else {
            
            $this->setConfig();
            $webpay = new Webpay( $this->config );
            $this->transaccion = $webpay->getNormalTransaction();
           
        }
	}
    
	function init(){
		if ( is_null($this->ammount) || is_null($this->order) || is_null($this->return) || is_null($this->finish) || is_null($this->session) ){
			throw new \Exception("The data required is nulled", 1);			
		}

		$init = $this->transaccion->initTransaction( 
			$this->ammount,
			$this->order,
			$this->session,
			$this->return,
			$this->finish
		);

		return $init;
	}
    
    function setConfig(){
        $this->config = new ConfigWebpay;
        $this->config->setEnvironment("PRODUCCION");
        $this->config->setCommerceCode(AppConfig::CommerceCodeProductive);
        $this->config->setPrivateKey(
          "-----BEGIN RSA PRIVATE KEY-----\n".
          "MIIEpAIBAAKCAQEAt6UfpfnocsNpoxaYTWxpNpDrkTMeI5vnX16ENFXvqCQpuZoE\n".
          "gXPlHqmbaEyobUXbkzDRI4DWPrd22RDKs1D7gS7/r/vamEeG9nBKRDclj23E10vb\n".
          "qdjkbXj6XbBmgV05vHmuhxLJf20LzMdUsIQ2SD5VjP0rPZ5UjN8FIcqWg5D7pjRF\n".
          "GTr/kkAUN1/PCOaJpCF4O2z8FUquT389Rzqgln0hDCKCeyGMQFDAlaOPgUKyUAJu\n".
          "3NdUnWBAAyDYO/ENi61ChknmbJDL4HiRW+Mvf1MHQxiaJKkI8bNF4/l/BZobn0L2\n".
          "q2Y9vqZD29gngSfQDi3+0Le4sdOeDq/vkE1czQIDAQABAoIBAHRQlJQGjjCqDm1q\n".
          "cTqQkK8r6NgFfXBmXYxtC+UuDOX9SaQxpersIdFi8XiFHSRg26sFf2EySABfKVpg\n".
          "pVIf17xBrVakeRZ8L0JFavR7zUFj8AnBFTcllcC0oDbY9IO5LUlv9Je+0Xrw8UlZ\n".
          "cw1+H/dv67Wp4EpdzwWOd+yoKN7Y0aPSTcAOgSi5N+aKa7n67At3cG1Dq3ycUVVY\n".
          "SOpAno1Uy90/6K1u9Cjp0Rq90/ui4a8mONazwQh+FixS+VygGRXmkYfOy8Cg3jBR\n".
          "CGRobREcIwdX1+O76Au+tXr/L1BZxcLs1wu/UB/PmNxMY4Govb08rR7/6X30eLGM\n".
          "nKszGAECgYEA3QSpVblD0gbFzmqqNEddeCknHzBz3gf0nlw7Z+FKwwO6M0RxfqoH\n".
          "9LXYEqUjvVdaRkL3mx5e/bMei/5rue5jfIRvifis8t7qIy5bDH4P4ZMER+BBdux/\n".
          "YObfx8W7WHH83YCNlhEvfv5iqQcUSOsRz8r8+FZsjJ42BYdu9sJvugECgYEA1LYn\n".
          "gHDU5gVUXUYmAKmgd423rGPcwvJLKjs6UmtMnHPits3aoe7RBGnqB2GCj5paBCsK\n".
          "ceABIGNblVoTKoEgqluIQCIzY0WjKch9MdhjDlDm26K9rvx20tCezb8WyFxvPWNN\n".
          "2LBtJ3cqEvWLAG0Ypoi1CPJXNTFZO6kS1r/Ras0CgYEAq4H6hXMGlex7gvpyqa7X\n".
          "cW891I4c26cAxAJ+dtX01fAGhdIO4GPBWLvjuFQ9r6ghfXRqAA1JWUWt5qS/o8DB\n".
          "otaCV2aJjs48kqBeNwt792fGYqA7LLXJAsEl1jgycSfDOX+QX2tml/1/QfskWpFP\n".
          "eRfjxjIKefQrp465JPMtEAECgYEAiKO2flB8woH77qroMJbGaOYVbdz8bBJe7HL9\n".
          "hQI+RWY/5bQY1NrnU9GBr1oZF4xMdM79N6dwsdCBfVBObYhjZmvD+4a8wfFy3Z1X\n".
          "ptRc1U5s7fv9o1G0NroiuQIebXjLUIDg+ehjRe3LjkBDGXP7WMcKnAOot5fKvYNf\n".
          "ganYqaUCgYAdKCRTfbW0esFv9Dh2Ni6L3pcdJZNXZsj1M53aMfOOTkqfYHFuh8+Q\n".
          "V5VZBasHFN+swYNsCwQm/ew6vgrhgZkR6Ec8cwCmXfA9zN68PHN392QKG+W5302d\n".
          "XCo6aeYt5Im+8eda+27PO0Y3bEPC/RyWyJ10W2YZMf512WQr72B7JQ==\n".
          "-----END RSA PRIVATE KEY-----");
        
        
        $this->config->setPublicCert(
          "-----BEGIN CERTIFICATE-----\n".
          "MIIDNDCCAhwCCQDyHdBJ2hlcgzANBgkqhkiG9w0BAQsFADBcMQswCQYDVQQGEwJB\n".
          "VTETMBEGA1UECAwKU29tZS1TdGF0ZTEhMB8GA1UECgwYSW50ZXJuZXQgV2lkZ2l0\n".
          "cyBQdHkgTHRkMRUwEwYDVQQDDAw1OTcwMzQ5MTkzMDUwHhcNMjAwMzI4MjIyODAy\n".
          "WhcNMjQwMzI3MjIyODAyWjBcMQswCQYDVQQGEwJBVTETMBEGA1UECAwKU29tZS1T\n".
          "dGF0ZTEhMB8GA1UECgwYSW50ZXJuZXQgV2lkZ2l0cyBQdHkgTHRkMRUwEwYDVQQD\n".
          "DAw1OTcwMzQ5MTkzMDUwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQC3\n".
          "pR+l+ehyw2mjFphNbGk2kOuRMx4jm+dfXoQ0Ve+oJCm5mgSBc+UeqZtoTKhtRduT\n".
          "MNEjgNY+t3bZEMqzUPuBLv+v+9qYR4b2cEpENyWPbcTXS9up2ORtePpdsGaBXTm8\n".
          "ea6HEsl/bQvMx1SwhDZIPlWM/Ss9nlSM3wUhypaDkPumNEUZOv+SQBQ3X88I5omk\n".
          "IXg7bPwVSq5Pfz1HOqCWfSEMIoJ7IYxAUMCVo4+BQrJQAm7c11SdYEADINg78Q2L\n".
          "rUKGSeZskMvgeJFb4y9/UwdDGJokqQjxs0Xj+X8FmhufQvarZj2+pkPb2CeBJ9AO\n".
          "Lf7Qt7ix054Or++QTVzNAgMBAAEwDQYJKoZIhvcNAQELBQADggEBAB4/86kYkttb\n".
          "fdGarM4zUHHfUaoGtYemzyovrpXwOA9MsjrZ4XSe3mdhJsu+U213FOVCaPh7T6Da\n".
          "0NrJ0q4chEk2VVg+wzZzHBUimFolvAmloRYoPuSjpr7U0p0W9e05ZbKVEXsuCodM\n".
          "ACqxRWRExBMNCycbSvdCQ4De2vuJF80Dcl/lBtF5EmaXkoozGMER9ldqedioNzCZ\n".
          "ddUBNptMtnXjrDCJlxkbFS2/w+lSch8EnTVCFtYTPSjkPtAwclUwLGJyVNQlxZXQ\n".
          "X/2eqtfNrNVsxgiSQa7eVXsWFEn/ongFGp1bDyV1Yqa4mpvj7xOCYry41m3Dyiso\n".
          "CKINFV6fjZQ=\n".
          "-----END CERTIFICATE-----"
        );
        return $this;
    }

	function verifyToken(){
		if ( is_null($this->token) ){
			throw new \Exception("Token is null", 1);	
		}

		$result = $this->transaccion->getTransactionResult($this->token);
		return $result;
	}
        
        function getTypeSale($tipo){
            switch ($tipo) {
                case 'VD':
                    return "Venta Débito.";
                    break;
                case 'VN':
                    return "Venta Normal.";
                    break;
                case 'VC':
                    return "Venta en cuotas.";
                    break;
                case 'SI':
                    return "3 cuotas sin interés.";
                    break;
                case 'S2':
                    return "2 cuotas sin interés.";
                    break;
                case 'NC':
                    return "N Cuotas sin interés";
                    break;
                case 'VP':
                    return "Venta Prepago.";
                    break;
                case '':
                  return "Rechazo de transacción.";
                break;
                default:
                  return "Rechazo de transacción.";
                break;
            }
        }

	function getMessageByResponseCode($responsecode){
		
	}
}
?>