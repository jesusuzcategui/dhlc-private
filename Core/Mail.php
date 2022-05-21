<?php namespace Core;

defined("BASEPATH") or die("Access denied");

//require("PHPMailer.php");
//require("SMTP.php");

use Core\PHPMailer;
use Core\SMTP;

class Mail {

	
    public function	config($de,$con,$nombde,$para,$nombpara,$asunto,$cuerpo,$mensajeadicional,$direccionarchivo="",$nombrearchivo=""){
    	    
		$my_path ="./App/views/reports/usuarios.php";
    	   $mail=new PHPMailer(true);
		         try{
			//Server settings
		    $mail->SMTPDebug = 0;                                       // Enable verbose debug output
		    $mail->isSMTP();                                            // Set mailer to use SMTP
		    $mail->Host       = 'smtp.gmail.com';                // Specify main and backup SMTP servers
		    $mail->SMTPAuth   =  true;                                   // Enable SMTP authentication
		    $mail->Username   =  $de;                     // SMTP username
		    $mail->Password   = $con;                               // SMTP password
		    $mail->SMTPSecure = 'smtp';                                  // Enable TLS encryption, `ssl` also accepted
		    $mail->Port       =  587;                                    // TCP port to connect to
		    #$mail->Port       =  465;                                    // TCP port to connect to
		    $mail->CharSet = "UTF-8";

		    //Recipients
		    $mail->setFrom($de, $nombde);
		    $mail->addAddress($para,$nombpara);     // Add a recipient
		    //$mail->addAddress('ellen@example.com');               // Name is optional
		    //$mail->addReplyTo('info@example.com', 'Information');
		    //$mail->addCC('cc@example.com');
		    //$mail->addBCC('bcc@example.com');

		    // Attachments
		   // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
		   // $mail->addAttachment($direccionarchivo,$nombrearchivo);    // Optional name //$direccionarchivo
			if($direccionarchivo != "" && $nombrearchivo != ""):
				$mail->addStringAttachment($direccionarchivo,$nombrearchivo,'base64', 'application/pdf');
			endif;
            $mail->AddEmbeddedImage('https://locutorios.cl/recargas/images/logoweb.svg', 'logoLocutorios');
		    // Content
		    $mail->isHTML(true);                                  // Set email format to HTML
		    $mail->Subject = $asunto;
		    $mail->Body    = $cuerpo;
			$mail->AltBody = $mensajeadicional;
			
			$mail->SMTPOptions = array(
				'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
				)
			);

		    $mail->send();
		    return json_encode(["data"=>true,
		             "message"=>"se envio el mensaje correctamente "]);

		}catch(Exception $e){
			 return json_encode(["data"=>false,
			         "message"=>"error en el envio de correo verifique su cuenta gmail".$e]);
		}  
	}
}






