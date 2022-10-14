<?php
#--------------------------------------------------------------------------#
# Descripción      : Clase de conexion a base de datos.                    #
# Fecha de creación: 09 /01/ 2015                                          #
# Autor            : Lizeth Manchego Suarez                                #
#**************************************************************************#
# Ultima Alteracion:                                                       #
#--------------------------------------------------------------------------#

# Clase encargada de gestionar las conexiones a la base de datos.
class DbLi
{
	private $servidor;
	private $usuario;
	private $password;
	private $base_datos;
	private $link;
	private $rsc;
	private $array;
	public $rutaRelativa;
	private $ruta;

	static $_instance;
	
	# La función construct es privada para evitar que el objeto pueda ser creado mediante new
	private function __construct($rutaRelativa)
	{
		if($rutaRelativa ) $this->rutaRelativa = $rutaRelativa;
		$this->conxion_default();
		$this->conectar();
	}

	# Evitamos el clonaje del objeto. Patrón Singleton
	private function __clone(){ }
	
	# Función encargada de crear, si es necesario, el objeto. Esta es la función que debemos llamar desde 
	# fuera de la clase para instanciar el objeto, y así, poder utilizar sus métodos
	public static function iniciar($rutaRelativa = '', $nuevo = 1)
	{
		if($nuevo) self::$_instance = new self($rutaRelativa);
		else
			if (!(self::$_instance instanceof self))
				 self::$_instance = new self($rutaRelativa);
		
		return self::$_instance;
	}
	
	# Inicia los parametros por defecto para la conexion a la bd ( servidor, usuarios, clave, bd)
	public function conxion_default()
	{
		$carpeta = explode('/', $_SERVER["PHP_SELF"]);
		$this->ruta = ($this->rutaRelativa) ? $this->rutaRelativa : $_SERVER["DOCUMENT_ROOT"].'/'.$carpeta[1].'/conexion';
		#$contenido = include($this->ruta . '/bd.inc.php');
		$contenido = include('bd.inc.php');
		$this->servidor = trim( $servidor );
		$this->usuario = trim( $usuario  );
		$this->password = trim( $password  );
		$this->base_datos = trim( $bd );
	}
	
	# Realiza la conexión a la base de datos.
	private function conectar()
	{
		$this->link = mysqli_connect($this->servidor, $this->usuario, $this->password);
		if( $this->link === false ) die($this->servidor.', '.$this->usuario.' Error al conectar a MySql.');
		if( mysqli_select_db($this->link, $this->base_datos) === false )
			die('Error al conectar la base de datos.');
		@mysqli_query("SET NAMES 'utf8'");
	}
        
       
	
	# Método para ejecutar una sentencia sql.
	public function ejecutar($sql)
	{
		$this->stmt = mysqli_query($this->link, $sql);
		if( $this->stmt === false ) $this->errores( $sql, 1 );
		return $this->stmt;
	}
        
        # Método para ejecutar multiples sentencias sql.
	public function multi_ejecutar($sql){                
                /* execute multi query */
                if (mysqli_multi_query($this->link, $sql)) {
                    do {
                        /* store first result set */
                        if ($result = mysqli_store_result($this->link)) {
                            while ($row = mysqli_fetch_row($result)) {
                            }
                            mysqli_free_result($result); 
                        }
                        
                        if(mysqli_more_results($this->link)){
                            
                        }
                    }while (mysqli_more_results($this->link) && mysqli_next_result($this->link)); 
                }
                $this->stmt  = mysqli_errno($this->link);
                if($this->stmt!=0){
                    $this->errores( $sql, 1 );
                }
                return $this->stmt;
	}

	# Método para obtener una fila de resultados de la sentencia sql.
	public function obtener_fila($rsc, $fila = 0)
	{
		if ($fila == 0){
			$this->array = mysqli_fetch_array($rsc);
		}
		else
		{
			mysqli_data_seek($rsc, $fila);
			$this->array = mysqli_fetch_array($rsc);
		}
		return $this->array;
	}
	
	# Obtiene una fila del resource, si no se envia el segundo parametro se obtiene la primera.
	public function obtener_fila_a($rsc, $fila = 0)
	{
		if ($fila == 0){
			$this->array = mysqli_fetch_assoc($rsc);
		}
		else
		{
			mysqli_data_seek($rsc, $fila);
			$this->array = mysqli_fetch_assoc($rsc);
		}
		return $this->array;
	}
	
	# Retorna una sola fila de la consulta enviada en un array, agrega el limit 1 por defecto.
	public function una_fila($sql){
		$sql .= " LIMIT 0, 1";
		$rsc = $this->ejecutar($sql);
		return $this->obtener_fila($rsc);
	}
	
	# Retorna una sola fila de la consulta enviada en un array asociativo, agrega el limit 1 por defecto.
	public function una_fila_a($sql)
	{
		$sql = $sql . " LIMIT 0, 1";
		$rsc = $this->ejecutar($sql);
		return $this->obtener_fila_a($rsc);
	}
	
	# Retorna el valor del primer campo, de la primera fila de la consulta enviada.
	public function un_campo($sql)
	{
		$fila = $this->una_fila( $sql);
		return $fila[0];
	}

	# Devuelve el último id del insert introducido
	public function ultimo(){
		return mysqli_insert_id($this->link);
	}
	
	# Devuelve el numero de filas que se encontraron en la consulta.
	public function num_reg( $rsc ){
		return mysqli_num_rows($rsc);
	}
	
	# Registra los errores ocacionados por las consultas mysql.
	private function errores($sql, $tipo = 0)
	{
		switch( $tipo )
		{
			case 1: $motivo = "Error en la consulta: ( ".mysqli_error($this->link)." ) "; break;
			case 2: $motivo = 'Consulta vacia.'; break;
			default: $motivo = 'Mostrar Consulta.'; break;
		}
		
		# Detectar dirección IP
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) $ip = $_SERVER['HTTP_CLIENT_IP'];
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))	$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else $ip = $_SERVER['REMOTE_ADDR'];
		
		$fecha = date('d / m / Y -  h:i');
		$msj = " \r\n---- \r\n".$fecha." \r\n".$motivo." \r\n".'Consulta : '. $sql."  \r\n";
		#file_put_contents( $this->ruta."/mysql.log", $msj, FILE_APPEND );
		file_put_contents( "mysql.log", $msj, FILE_APPEND ); 
	}
	
	# Mostrar mensajes que se deseen en un archivo plano.
	public function mostrar($texto)
	{
		$this->errores($texto);
	}
	
	# Devuelve 1 registro del resource formato objeto
	public function obtener_objFila($rsc){
		$oRow = mysqli_fetch_object($rsc);
		return $oRow;
	}
	
	# Devuelve los registros del resource formato objeto
	public function obtener_objFilas($rsc){
		$aRta = array();
		while( $oRow = $this->obtener_objFila($rsc) ){
			$aRta[] = $oRow;
		}
		return $aRta;
	}
	
	# Devuelve los registros del resource formato objeto
	public function obtener_objFilaUnica($rsc){
		$oRta = new stdClass();
		while( $oRow = $this->obtener_objFila($rsc) ){
			$oRta = $oRow;
		}
		return $oRta;
	}
        
	# Metodo para cerrar conexion 
	public function cerrarConexion() {
		mysqli_close($this->link);
	}      
}
?>