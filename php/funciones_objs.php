<?php		
require_once("../../../session.php");
require_once("../../../base/clase_bases.php");
if(!isset($_SESSION["idusuweb"]))
{
	echo '<script>window.location="../../../";</script>';
}
else
{
	switch ($_POST["op"])
	{
		case "inicio":
		{
			inicio();
			break;
		}
		case "buscar":
		{
			buscar($_POST["idsede"],$_POST["idtipo"],$_POST["idtipod"],$_SESSION["idusuweb"]);
			break;
		}
		case "aceptar":
		{
			aceptar($_SESSION["idusuweb"],$_POST["iddonante"],$_POST["idestado"],$_POST["fecha"],$_POST["obs"],$_POST["ciudad"],$_POST["barrio"],$_POST["d"],$_POST["d1"],$_POST["d2"],$_POST["d3"],$_POST["d4"],$_POST["d5"],$_POST["d6"],$_POST["correo"]);
			break;
		}
		case "seleccion":
		{
			seleccion($_POST["idtipo"],$_POST["idd"],$_SESSION["idusuweb"]);
			break;
		}
		case "carga":
		{
			carga($_POST["desde"],$_POST["hasta"],$_POST["idsede"],$_POST["abo"],$_POST["rh"],$_SESSION["idusuweb"]);
			break;
		}
		case "vercarga":
		{
			vercarga($_POST["idsede"]);
			break;
		}
		case "newDonante":
		{
			newDonante($_POST["name"],$_POST["apellido"],$_POST["sexo"],$_POST["tel"],$_POST["doc"],$_POST["correo"]);
			break;
		}
		case "tipificacion":
		{
			tipificacion($_POST["num"]);
			break;
		}
		
	}
}
//carga('01-08-2019', '20-08-2019', 1);
/**/
function tipificacion($num)
{
	require_once("../../../general/objetos/DonantesPotenciales.php");
	$obj = new DonantesPotenciales();
	$datos = $obj->getEstadoActual($num);
	echo $datos[0]["estado"]." (".$datos[0]["idatencion"].")";
}
function newDonante($name,$apellido,$sexo,$tel,$doc,$correo)
{
	require_once("../../../general/objetos/DonantesPotenciales.php");
	$obj = new DonantesPotenciales();
	$newDonante=$obj->newDonante($name,$apellido,$sexo,$tel,$doc,$correo);

	if($newDonante[0]['iddonante']>=1)
	{
		echo 'Exito';
	} else { echo 'Error'; }
}
/**/
function vercarga($idsede)
{
	require_once("../../../general/objetos/DonantesPotenciales.php");
	$obj = new DonantesPotenciales();
	$datos=$obj->setVerCarga($idsede);
	for($x=0;$x<count($datos);$x++)
	{
		echo $datos[$x]["desde"].",".$datos[$x]["hasta"].",".$datos[$x]["abo"].",".$datos[$x]["rh"].",".$datos[$x]["fecha"]."\n";
	}
}
function carga($desde, $hasta, $idcentro,$abo,$rh,$idusuario)
{
	require_once("../../../general/objetos/DonantesPotenciales.php");
	$obj = new DonantesPotenciales();
	$total=$obj->setCarga($desde, $hasta, $idcentro,$abo,$rh,$idusuario);
	echo "<h1>TOTAL:$total</h1>";
}
function seleccion($idtipo,$iddonante,$idusuario)
{
	require_once("../../../general/objetos/DonantesPotenciales.php");
	$obj = new DonantesPotenciales();
	$res = $obj->setMarcaRegistro($iddonante, $idusuario);
	if($res[0]["iddonante"]>0)
	{
		$datos = $obj->getEstadosOrigen($idtipo);
		
		for($x=0;$x<count($datos);$x++)
		{
			if($datos[$x]["idestado"]>0)
				echo '<option value="'.$datos[$x]["idestado"].'" data-obliga="'.$datos[$x]["obliga"].'">'.$datos[$x]["estado"].'</option>';
		}
		echo "|1";
	}
	else
		echo "|0";
}
function aceptar($idusuario,$iddonante,$idestado,$fecha,$obs,$ciudad,$barrio,$d,$d1,$d2,$d3,$d4,$d5,$d6,$correo)
{
	require_once("../../../general/objetos/DonantesPotenciales.php");
	$obj = new DonantesPotenciales();
	//$datos = $obj->setAceptar2($idusuario,$iddonante,$idestado,$fecha,$obs,$ciudad,$barrio,$d,$d1,$d2,$d3,$d4,$d5,$d6);
	$datos = $obj->setAceptar3($idusuario,$iddonante,$idestado,$fecha,$obs,$ciudad,$barrio,$d,$d1,$d2,$d3,$d4,$d5,$d6,$correo);
	if($datos[0]["idhistorico"]>0)
		echo $datos[0]["idhistorico"];
	else
		echo 0;
}

function inicio()
{
	require_once("../../../general/objetos/DonantesPotenciales.php");
	$obj = new DonantesPotenciales;
	//$actualizarEstados = $obj->actualizarEstados();
	$datos = $obj->getEstadosInicio(0);
	$estados='';

	for($x=0;$x<count($datos);$x++) {
		$estados.= '<option value="'.$datos[$x]["idestado"].'">'.$datos[$x]["estado"].'</option>';
	}

	$blo = "<h4 class='fw-bold text-secondary'>Donantes bloqueados</h4>";
	
	$datos = $obj->getBloqueos();
	for ($x=0;$x<count($datos);$x++)
	{
		if ($datos[$x]["idcentro"]==1) {
			$sede="Bogotá";
		}
		elseif ($datos[$x]["idcentro"]==2) {
			$sede="Ibagué";
		}
		elseif ($datos[$x]["idcentro"]==3) {
			$sede="Barranquilla";
		}
		else {
			$sede="";
		}

		$blo .= "
			<div class='d-flex align-items-center justify-content-between rounded-3 border shadow-sm mb-2 p-3'>
				<div class='fw-bold'>{$datos[$x]["usuario"]}</div>
				<div class='d-flex align-items-center small'>
					<span class='text-danger'>{$datos[$x]["cantidad"]} bloqueos</span>
					<span class='ms-2 text-secondary'> | {$sede}</span>
				</div>
			</div>";
	}
	
	$a = array("estados"=>$estados,"bloq"=>$blo);
	echo json_encode($a);
}

function buscar($idsede, $idtipo, $idtipod,$idusuario)
{
	require_once("../../../general/objetos/DonantesPotenciales.php");
	$obj = new DonantesPotenciales;
	$datos = $obj->getBuscar($idsede, $idtipo, $idtipod,'','',$idusuario);
	$tllamadas = $obj->getllamadas($idusuario);

	$resp = "<h4 class='fw-bold text-secondary'><i class='i-search'></i> Resultados de búsqueda</h4>";
	$idatencion = "";
	for ($x=0;$x<count($datos);$x++)
	{
		$fondo = "";
		if ($datos[$x]["iddonante"]>0)
		{
			if ($datos[$x]["idatencion"]>0)
			{
				if ($datos[$x]["idatencion"]==$idusuario) {
					$fondo='fondoazul';
				}
				else {
					$fondo='fondorojo';
				}

				$idatencion="({$datos[$x]["idatencion"]})";
			}

			$datosDonante = json_encode(array(
				"iddonante" => $datos[$x]["iddonante"],
				"celulares" => [
					$datos[$x]["celular1"],
					$datos[$x]["celular2"],
					$datos[$x]["telefonocasa"],
					$datos[$x]["telefonotrabajo"]
				],
				"nombre" => $datos[$x]["nombres"] . " " . $datos[$x]["apellidos"],
				"ultima_donacion" => $datos[$x]["ultima_donacion"],
				"lugar" => $datos[$x]["colecta"],
				"observacion" => $datos[$x]["obs"]
			));

			$resp .= "
			<div id='d{$datos[$x]["iddonante"]}' class='rounded-3 border shadow-sm mb-2 p-3 {$fondo}'>
				<div class='d-flex align-items-center justify-content-between'>
					<div class='fw-bold'>{$datos[$x]["nombres"]} {$datos[$x]["apellidos"]}</div>
					<div class='text-end'>
						<b>{$datos[$x]["tipodonacion"]}</b>
					</div>
				</div>

				<div class='d-flex align-items-center justify-content-between small'>
					<div><i class='i-address-card-solid'></i> {$datos[$x]["ndocumento"]} | Género: <b>{$datos[$x]["sexo"]}</b></div>
					<div>{$datos[$x]["colecta"]} | {$datos[$x]["ciudad"]}</div>
				</div>

				<div class='d-flex align-items-center justify-content-end small'>
					<div>Última modificación: {$datos[$x]["ultima_donacion"]}</div>
				</div> ".
				($datos[$x]["fecharespuesta"] != "" ? "<hr>" : "")
				." <div>
					<div>Respuesta: {$datos[$x]["fecharespuesta"]}</div>
					<div>
						{$idatencion} {$datos[$x]["obs"]}
					</div>
				</div>

				<div class='d-flex align-items-center justify-content-end mt-2'>
					<button class='btn btn-sm btn-sky text-white' onclick='seleccion({$datos[$x]["iddonante"]}, ".$datosDonante.", {$datos[$x]["ndocumento"]})'>
						<i class='i-check-circle-solid'></i> Reservar
					</button>
				</div>
			</div>";
		}
	}
	
	$a = array(
		"respuesta" => $resp,
		"tllamadas" => $tllamadas[0]["cantidad"]
	);
	echo json_encode($a);
}
function mascaraNdonante($ndonante)
{
	$tamano=8;
	$tamanoact = strlen($ndonante);
	for($x=0;$x<($tamano-$tamanoact);$x++)
	{
		$ndonante = "0".$ndonante;
	}
	return $ndonante;

}
function espanol($texto) //REPARA CUALQUIER TEXTO A UTF-8
{
	//$texto = htmlentities($texto , ENT_QUOTES); //No permite codigo HTML viejo xampp
	$texto = htmlentities($texto , ENT_QUOTES,"ISO-8859-1"); //No permite codigo HTML nueva version de  xampp
	$texto = str_replace("\r","<br />",$texto); //Asignar codigo espacios
	$texto = utf8_encode($texto); //ENCODE A UTF-8
	$texto = iconv("ISO-8859-1" , "UTF-8", $texto); // Convierte ISO-8859-1 UTF-8
	//return str_replace("'","\\\'",$texto); 
	return $texto;
}
