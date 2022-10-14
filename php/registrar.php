<?php
session_start();
#ini_set('display_errors', 'On');
#ini_set('display_errors', 1);
#--------------------------------------------
include("Db.class.php"); 
$cx = DbLi::iniciar();
date_default_timezone_get('America/Bogota');
extract($_POST);
#---------------------------------------------
$clave = md5($Clave);
#Se coloca inicialmente $fechanac y $sexo vacíos estos campos se actualizan más adelante
$fechanac = '';#$year.str_pad($mes, 2, 0, STR_PAD_LEFT).str_pad($dia, 2, 0, STR_PAD_LEFT);
$sexo = '';
$fechareg = date('Ymd');
$horareg = date('H:i:s');
if(isset($terminos) and $terminos=='on'){
    $acepto = 'si';
}
$sql1 = "SELECT * FROM u229811426_alta.usuarios WHERE cedula = '$cedula'";
$stmt1 = $cx->ejecutar($sql1);
$total1 = $cx->num_reg($stmt1);
if($total1>0){
    #No lo registramos
    echo 'no';
} else {
$sql = "INSERT INTO u229811426_alta.usuarios (
    id,
    email,
    clave,
    nombre,
    apellidos,
    cedula,
    tipo,
    sexo,
    fechanac,
    fechareg,
    horareg,
    reciboferta,
    acepto
  ) 
  VALUES
    (
      '0',
      '$email',
      '$clave',
      '$nombre',
      '$apellidos',
      '$cedula',
      'cc',
      '$sexo',
      '$fechanac',
      '$fechareg',
      '$horareg',
      '$acepto',
      '$acepto'
    ) ;";
 $stmt = $cx->ejecutar($sql);
 $total = $cx->num_reg($stmt);
 $sql2 = "SELECT id FROM u229811426_alta.usuarios WHERE cedula = '$cedula' ORDER BY id DESC LIMIT 1;";
 $stmt2 = $cx->ejecutar($sql2);
 $total2 = $cx->num_reg($stmt2);
 $row2 = $cx->obtener_fila($stmt2,0);
#Sesiones de usuario----------------
$_SESSION['idusuario'] = $row2['id'];
$_SESSION['email'] = $email;
$_SESSION['nombre'] = $nombre;
$_SESSION['apellidos'] = $apellidos;
$_SESSION['cedula'] = $cedula;
$_SESSION['tipo'] = 'cc';
$_SESSION['sexo'] = $sexo;
$_SESSION['fechanac'] = $fechanac;
#-----------------------------------
echo 'Registro con éxito
<script language="javascript" >
	function redireccionar() {
		window.location = "index.php"
	}
	setTimeout ("redireccionar()", 2000);
 </script>
';
}
?>