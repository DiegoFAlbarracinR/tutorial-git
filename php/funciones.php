<?php 
ini_set('display_errors', 'On');
ini_set('display_errors', 1);
function mesesEsp($n){
    $meses = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
    return $meses[intval($n)-1];
}
?>