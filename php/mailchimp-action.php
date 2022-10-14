<?php
ini_set('display_errors', 'On');
ini_set('display_errors', 1);
if(isset($_POST['url'])){
   $email = $_POST['url'];
    if(!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL) === false){
      // MailChimp API credentials
			/*require_once  'MCAPI.class.php'; // mailchimp class library
			
					$apiKey = 'c9a2d74ee39c18ea82584ad972bb66b3-us15';
					$listID = '7d73f93b10';
			$apiUrl = 'http://api.mailchimp.com/1.3/';
			//CONFIGURE VARIABLES START.		
			$api = new MCAPI($apiKey);		
			$merge_vars = array('FNAME' => '');
			
			//CONFIGURE VARIABLES FINISH.
			//MAKE API CALLSE FOR MAILCHIMP START.
			
			$retval = $api->listSubscribe( $listID, $email, $merge_vars );
			//MAKE API CALLSE FOR MAILCHIMP FINISH.
			//CONFIGURE ERROR OR SUCCESS PROCESS START.
			if ($api->errorCode){
				$msg= $api->errorMessage."\n";
			} else {
				$msg= '<p style="color: #34A853">'."Successfully Subscribed. Please check confirmation email.".'</p>';
			}*/
			//Correo al cliente
			require("phpmailer/class.phpmailer.php");							
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->SMTPAuth = true;
			$mail->Host = "smtp.hostinger.co"; // SMTP a utilizar. Por ej. smtp.elserver.com
			$mail->Username = "contacto@altabelleza.co"; # Correo completo a utilizar
			$mail->Password = "C0nt4cT3N0s"; // Contraseña
			$mail->Port = 587; // Puerto a utilizar
			$mail->From = "info@altabelleza.co";
			$mail->FromName = "Matilda Alta Belleza.";
			$mail->Subject = "Suscripcion recibida";
			$mail->AddAddress($email);
			$body = "<strong>Matilda Alta Belleza:</strong>
			<br><br>Bienvenido(a) su correo:".$email.", ha sido agregado a nuestra lista.<br><br>
			Gracias por suscribirse a Matilda Alta Belleza:
			<br>Le estaremos enviando informaci&oacute; acerca de novedades, ofertas y descuentos de nuestros servicios.<br><br>
			Fecha de suscripci&oacute;n: ".date("d/m/Y")."";
			$body.= "<br><br><img src='http://www.altabelleza.co/images/logo-matilda-email.png'>
			<br><i>Matilda Alta Belleza - ".date("Y")."</i>";
			$mail->Body = $body;
			$mail->IsHTML(true);

			

			$msg = "Suscrito con éxito. Por favor, compruebe el correo electrónico de confirmación.";
			echo json_encode($msg);
			die();
    }
  }
?>