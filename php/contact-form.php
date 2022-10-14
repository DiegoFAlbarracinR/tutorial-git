<?php
include("Db.class.php"); 
$cx = DbLi::iniciar();
date_default_timezone_get('America/Bogota');
#----------------------------------------------
if(isset($_POST["action"])) {
	$name = $_POST['name'];        // Sender's name
	$email = strtolower($_POST['email']);      // Sender's email address
	$phone  = $_POST['phone'];     // Sender's phone number
	$message = $_POST['message'];  // Sender's message
	
	/*$headers = 'De: Contáctenos <contacto@altabelleza.co>' . "\r\n";
	$to = $email;     // Recipient's email address
	$subject = 'Mensaje de Matilda Alta Belleza Contactenos '; // Message title
	$body = " De: $name \n E-Mail: $email \n Telefono : $phone \n Mensaje : $message"  ;*/
	
	$fecha =  date("Ymd");
	$hora = date("H:i:s");
	#Correo al cliente-----------------------------------------------------------------------------
	require("phpmailer/class.phpmailer.php");							
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->SMTPAuth = true;
	$mail->Host = "smtp.hostinger.co"; // SMTP a utilizar. Por ej. smtp.elserver.com
	$mail->Username = "contacto@matildaaltabelleza.com"; # Correo completo a utilizar
	$mail->Password = "=0*xKF&7"; // Contraseña
	$mail->Port = 587; // Puerto a utilizar
	$mail->From = "contacto@matildaaltabelleza.com";
	$mail->FromName = "Matilda Alta Belleza.";
	$mail->Subject = "Su mensaje ha sido enviado";
	$mail->AddAddress($email);
	$body = "<strong>Matilda Alta Belleza:</strong>
	<br><br>Estimado(a):".ucwords($name).", <br><br>
	Gracias por contactarse con Matilda Alta Belleza:
	<br>Su comentario fue recibido pronto se le enviar&aacute; respuesta a su solicitud<br><br>
	Fecha de contacto: ".$fecha."";
	$body.= "<br><br><img src='http://www.matildaaltabelleza.com/images/logo-matilda-email.png'>
	<br><i>Matilda Alta Belleza - ".date("Y")."</i>";
	$mail->Body = $body;
	$mail->IsHTML(true);
	#Correo de notificacion --------------------------------------------------------------------
	$emailNotificacion = 'bvianap@gmail.com';
	$mail2 = new PHPMailer();
	$mail2->IsSMTP();
	$mail2->SMTPAuth = true;
	$mail2->Host = "smtp.hostinger.co"; // SMTP a utilizar. Por ej. smtp.elserver.com
	$mail2->Username = "contacto@matildaaltabelleza.com"; # Correo completo a utilizar
	$mail2->Password = "=0*xKF&7"; // Contraseña
	$mail2->Port = 587; // Puerto a utilizar
	$mail2->From = "contacto@mailtdaaltabelleza.com";
	$mail2->FromName = "Matilda Alta Belleza.";
	$mail2->Subject = "Contacto por pagina web: ".$name;
	$mail2->AddAddress($emailNotificacion);
	$mail2->AddBCC('macrodiego24@yahoo.es');
	$body2 = "<strong>Matilda Alta Belleza: te cont&aacute;ctan por p&aacute;g web.</strong>
	<br><br><strong>Nombre(a)</strong>: ".ucwords($name).", <br>
	<strong>Email</strong>: ".$email.", <br>
	<strong>Tel&eacute;fono</strong>: ".$email.", <br>
	<strong>Mensaje</strong>: ".$message.", <br>
	<br>
	Fecha de contacto: ".$fecha." ".$hora."";
	$body2.= "<br><br><img src='http://www.matildaaltabelleza.com/images/logo-matilda-email.png'>
	<br><i>Matilda Alta Belleza - ".date("Y")."</i>";
	$mail2->Body = $body2;
	$mail2->IsHTML(true);
	#Iniciamos la consulta de inserción en la Base de datos------------------------------------
	$fecha = date("Ymd");
	$hora = date("h:i:s");
	$sql = "INSERT INTO contacto (
		id,
		nombre,
		correo,
		telefono,
		comentario,
		fecha,
		hora
	) 
	VALUES
		(
			'0',
			'$name',
			'$email',
			'$phone',
			'$message',
			'$fecha',
			'$hora'
		) ;";

	// init error message
	$errmsg='';
	// Check if name has been entered
	if (isset($_POST['name']) && $_POST['name'] == '') {
		$errmsg .= '<p>Por favor ingrese su nombre.</p>';
	}
	// Check if email has been entered and is valid
	if (!$_POST['email'] || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$errmsg .= '<p>Por favor ingrese un correo electronico valido.</p>';
	}
	//Check if phone number has been entered
	if ( isset($_POST['phone']) && $_POST['phone'] == '') {
		$errmsg .= '<p>Por favor ingrese su telefono.</p>';
	}
	
	//Check if message has been entered
	if ( isset($_POST['message']) && $_POST['message'] == '') {
		$errmsg .= '<p>Por favor deje su mensaje.</p>';
	}

	/* Check Google captch validation */
	if( isset( $_POST['g-recaptcha-response'] ) ){
		$error_message = validation_google_captcha( $_POST['g-recaptcha-response'] );
		if($error_message!=''){
			$errmsg .= $error_message;
		}
	}	
	
	$result='';
	// If there are no errors, send the email
	if (!$errmsg) {
		if (/*mail ($to, $subject, $body, $headers)*/ $mail2->Send()) { #<--Se envía el correo de confirmación al cliente
			$mail->Send(); #También se envía el correo de notificación al Negocio
			$stmt = $cx->ejecutar($sql); #Se guarda en la Base de Datos
			$result='<div class="alert alert-success">Gracias por contactarnos. Su mensaje ha sido enviado con éxito. Nos pondremos en contacto con usted muy pronto!</div>';
		}
		else {
		  $result='<div class="alert alert-danger">Lo siento, hubo un error al enviar tu mensaje. Por favor, inténtelo de nuevo más tarde.</div>';
		}
	}
	else{
		$result='<div class="alert alert-danger">'.$errmsg.'</div>';
	}
	echo $result;
 }

/*
 * Validate google captch
 */
function validation_google_captcha( $captch_response){

	/* Replace google captcha secret key*/
	$captch_secret_key = '6LfnxqYUAAAAALTVCmkI8eNfyLMw1gYmGIB86tYR';
	
	$data = array(
            'secret'   => $captch_secret_key,
            'response' => $captch_response,
			'remoteip' => $_SERVER['REMOTE_ADDR']
        );
	$verify = curl_init();
	curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
	curl_setopt($verify, CURLOPT_POST, true);
	curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
	curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($verify);
	$response = json_decode( $response, true );
	$error_message='';
	if( isset($response['error-codes']) && !empty($response['error-codes'])){
		if( $response['error-codes'][0] == 'missing-input-secret' ){
			
			$error_message = '<p>The recaptcha secret parameter is missing.</p>';
			
		}elseif( $response['error-codes'][0] == 'invalid-input-secret' ){
			
			$error_message = '<p>The recaptcha secret parameter is invalid or malformed.</p>';
			
		}elseif( $response['error-codes'][0] == 'missing-input-response' ){
			
			$error_message = '<p>The recaptcha response parameter is missing.</p>';
			
		}elseif( $response['error-codes'][0] == 'invalid-input-response' ){
			
			$error_message = '<p>The recaptcha response parameter is invalid or malformed.</p>';
			
		}elseif( $response['error-codes'][0] == 'bad-request' ){
			
			$error_message = '<p>The recaptcha request is invalid or malformed.</p>';
		}
	}	
	if( $error_message !=''){
		return $error_message;
	}else{
		return '';
	}
  }
