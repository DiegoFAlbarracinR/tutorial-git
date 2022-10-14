<?php
#ini_set('display_errors', 'On');
#ini_set('display_errors', 1);
include("Db.class.php"); 
$cx = DbLi::iniciar();
date_default_timezone_get('America/Bogota');
#---------------------------------------------------------------------------------------------------
if(isset($_POST['url'])){
   $email = $_POST['url'];
    if(!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL) === false){
        //Correo al cliente
        require("phpmailer/class.phpmailer.php");							
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = "smtp.hostinger.co"; // SMTP a utilizar. Por ej. smtp.elserver.com
        $mail->Username = "info@matildaaltabelleza.com"; # Correo completo a utilizar
		$mail->Password = "Inf0M4t1Ld4"; // Contraseña
        $mail->Port = 587; // Puerto a utilizar
        $mail->From = "info@matildaaltabelleza.co";
        $mail->FromName = "Matilda Alta Belleza";
        $mail->Subject = "Suscripcion recibida";
        $mail->AddAddress($email);
        $body = "<strong>Matilda Alta Belleza:</strong>
        <br><br>Bienvenido(a) su correo:".$email.", ha sido agregado a nuestra lista.<br><br>
        Gracias por suscribirse a Matilda Alta Belleza:
        <br>Le estaremos enviando informaci&oacute;n acerca de novedades, ofertas y descuentos de nuestros servicios.<br><br>
        Fecha de suscripci&oacute;n: ".date("d/m/Y")."";
        $body.= "<br><br><img src='http://www.matildaaltabelleza.com/images/logo-matilda-email.png'>
        <br><i>Matilda Alta Belleza - ".date("Y")."</i>";
        $mail->Body = $body;
        $mail->IsHTML(true);
        #---------------------------------------------------------------------------------------------------
        #Se verifica que no exista el correo
        $sql_e = "SELECT
        email
        FROM
            suscritos 
        WHERE email = '$email' ;
        ";
        $stmt_e = $cx->ejecutar($sql_e);
        $total = $cx->num_reg($stmt_e);
        if($total > 0){
            $msg = "El correo. ".$email." ya existe en nuestra lista.";
        } else {
        #---------------------------------------------------------------------------------------------------
            #Se guarda en la Base de Datos
            $sql = "INSERT INTO suscritos (id, email, fecha, hora, acepto) 
            VALUES
            (
                '0',
                '$email',
                '".date("Ymd")."',
                '".date("h:i:s")."',
                'si'
            ) ;
            ";
            $stmt = $cx->ejecutar($sql);
            #Se envía el correo de suscripción
            $mail->Send();
            $msg = "Suscrito con éxito. ".$email." Por favor, compruebe el correo electrónico de confirmación.";
        }
        echo json_encode($msg);
    }
}