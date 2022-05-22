<?php
class Bases{
	var $tipo;
	var $base;
	var $resultado;
	var $ok;
	function Bases($tipo="sin tipo", $base="sin base"){
		$this->tipo=$tipo;
		$this->base=$base;
		}
	function setCambio($tipo, $base){
		$this->tipo=$tipo;
		$this->base=$base;
	}
	function getCual(){
		return $this->tipo;
	}
	function getQue(){
		return $this->base;
	}
	function getResultado(){
		return $this->resultado;
	}
	function getOk(){
		return $this->ok;
	}
	
	function conectarse(){
		if($this->tipo=="hexab")
		{
			//@ $conexion = ibase_connect("172.16.0.238/gds_10:E:\HEXABANK\DATAHEXABANK\GDB\hexabank.gdb", "SYSDBA", "masterkey")or die("Problemas en la conexion a el servidor HEXA");
			//$connection = ibase_connect ($host, $username, $password,'ISO8859_1', '100', '1'); 
			return true;
		}
		else if($this->tipo=="postg")
		{
			 $conexion = pg_connect("host='172.16.0.239' port='5432' dbname='".$this->base."' user='postgres' password='santos123'") or die("Problemas en la conexion a el servidor postgresql");
			return $conexion;
		}
		else if($this->tipo=="acces")
		{	
	
			@$conexion=odbc_connect($this->base, "","") or die("Problemas en la conexion a el servidor de access");
			return $conexion;
		}
		else if($this->tipo=="sqlsrv")
		{	
			$connectionInfo = array( "Database"=>$this->base, "UID"=>"edelphynf", "PWD"=>"Fuh3c0C0l0mb1@");
			@$conexion = sqlsrv_connect('172.16.0.242', $connectionInfo);
			if (! $conexion) {die(print_r(sqlsrv_errors(), true));}
			return $conexion;

		}
	}
	function cons($sql)
	{
		$opc = $this->conectarse();
		if($this->tipo=="hexab")
		{
			if ($opc)
			{
				require_once("nusoap.php");
				require_once("funciones_santos.php");
				if ($this->base==1)
				{
					$urlsede = urlbogota();
				}
				if ($this->base==2)
				{
					$urlsede = urlibague();
				}
				if ($this->base==3)
				{
					$urlsede = urlbquilla();
				}
				$cliente = new nusoap_client($urlsede);
				$resultado = $cliente->call('generica_hexa',array('param1'=>$sql,'param2'=>$_SESSION["idusuweb"],'param3'=>'santos_2141','param4'=>'<|**|>','param5'=>'<*|*>','param6'=>'|'));
				//$resultado = $cliente->call('generica_hexa',array('param1'=>$sql,'param2'=>$_SESSION["idusuweb"],'param3'=>'santos_2141','param4'=>'.','param5'=>'.','param6'=>'.'));
				$vali = explode("<|**|>",$resultado);
				//print_r($resultado);
				
				if($vali[0]=="ok")
				{
					return santos_str_matriz($resultado,'<|**|>','<*|*>','|');
				}
				else
				{
					echo "Error en la Consulta a Hexabank ".$this->base;
					
				}
				
			}
			else
			{
				echo "Error en la coneccion a el servidor  Hexa desde la consulta (CLASE DESACTUALIZADA)...";
			}
		}
		else if($this->tipo=="postg")
		{
			if ($opc)
			{
				$result = pg_query($sql) or die("Problemas en la consulta: $sql");
				if($result)
				{
					$this->ok = true;
					$this->resultado = pg_fetch_all($result);
				}
				else
				{
					$this->ok = false;
					$this->resultado = null;
				}
				pg_close($opc);
				return $this->resultado;
				
			}
			else
			{
				echo "Error en la conexión al servidor postgresql desde la consulta.";
			}
		}
		else if($this->tipo=="acces")
		{
			if ($opc)
			{
				@$result = odbc_exec($opc,$sql)or die("Problemas en la consulta de access: <p>".$sql);
				$array = array();
				while ($row = odbc_fetch_array($result)) {
					array_push($array, $row);
				}
				if($result)
				{
					$this->ok = true;
					$this->resultado = $array;
				}
				else
				{
					$this->ok = false;
					$this->resultado = null;
				}
				
				odbc_close($opc);
				return $array;
			}
			else
			{
				echo "Error en la coneccion a el servidor  Access desde la consulta...";
			}
		}
		else if($this->tipo=="sqlsrv")
		{	
			@$stmt = sqlsrv_query($opc, $sql);
			$array = array();
			 while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
					array_push($array, $row);
				}
			
			if ($stmt === false)
			{
				
				$this->ok = false;
				die(print_r(sqlsrv_errors(), true));
			
			}
			else
			{
				$this->ok = true;
				return $this->resultado = $array;
			}	
		}
	}
}
