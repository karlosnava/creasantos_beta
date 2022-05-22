<!DOCTYPE HTML>
<?php
SESSION_START();
if (!isset($_SESSION["idusuweb"]))
{
	echo '<script type="text/javascript">document.location="../../../../";</script>';
}
else
{
	if(isset($_REQUEST["idi"]))
	{
		require_once "../../../../base/clase_bases.php";
		require_once "../../../../general/objetos/incineraciones.php";
		$idincineracion = $_REQUEST["idi"];
		$inci = new Incineraciones();
		$datos = $inci->getDatos($idincineracion);
		$detalle = $inci->getDetalles($idincineracion);
		
	}
}
?>
<html lang="es-ES">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shartcut icon" href="../../../../imagenes/icono.png">
<link rel=stylesheet href="css/style.css" type="text/css">
<script type="text/javascript" src="../../../../js/jquery.js"></script>
<title>HEMOTARIO-FOLIO</title>
</head>
<body <?php if($_REQUEST["p"]==1){echo "onload='print()'";}?>>
	<div id="contenedor_documento" >
		<table border="0" width="100%" rules="none">
			<tr>
				<td>
					<table border="0" width="800px" class="centro centrotxt">
						<tr><td><img width="80px" src="../../../../imagenes/icono.png" /></td><td><font class="negrilla">FUNDACION HEMATOLOGICA COLOMBIA<p>ACTA DE INCINERACION PRODUCTO TERMINADO</font></td><td><img width="70px" src="../../../../imagenes/hemotario.png" /></td></tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table border="0" width="900px" >
						<tr><td width="150px" class="dertxt">SEDE:</td><td><font id="sede" class="izqtxt"><?php echo $datos[0]["sede"];?></font></td></tr>
						<tr><td width="150px" class="dertxt">FUNCIONARIO:</td><td><font id="funcionario" class="izqtxt"><?php echo $datos[0]["usuario"];?></font></td></tr>
						<tr><td class="dertxt">FECHA Y HORA:</td><td><font id="fecha" class="izqtxt"><?php echo $datos[0]["fecha"]." hora:".$datos[0]["hora"]?></font></td><td>ACTA No:&nbsp; <font id="nfolio"><?php echo $datos[0]["prefijo"]."    ".$datos[0]["nincineracion"]?></font></td></tr>
						<tr><td class="dertxt">TOTAL UNIDADES:</td><td><font id="stransporte" class="izqtxt"><?php echo $datos[0]["total"];?></font></td></tr>
					</table>
				</td>
			</tr>
			<tr><td><hr noshade="noshade" class="linea_egreso" /></td></tr>
			<tr>
				<td>
					<table border="1" width="100%" rules="rows">
						<?php 
							//echo '<tr class="colortitulo"><td>Hemoderivado</td><td>Motivo Descarte</td><td>N. Sello</td><td>N. Bolsa</td><td>ABO-RH</td><td>Fil</td><td>Irr</td><td>Lav</td><td>Volumen</td><td>Fecha Extraccion</td><td>Fecha Vencimiento</td></tr>';
							for($x=0;$x<count($detalle);$x++)
							{
								if($x==0 && strlen($detalle[$x]["producto"])>0)
									echo '<tr class="colortitulo" align="center"><td>Hemoderivado</td><td>Motivo Descarte</td><td>N. Sello</td><td>N. Bolsa</td><td>ABO-RH</td><td>Fil</td><td>Irr</td><td>Lav</td><td>Volumen</td><td>Fecha Extraccion</td><td>Fecha Vencimiento</td></tr>';
								if($detalle[$x]["filtrada"]>0){$filtrada="X";}else{$filtrada="";}
								if($detalle[$x]["irradiado"]>0){$irradiado="X";}else{$irradiado="";}
								if($detalle[$x]["lavado"]>0){$lavado="X";}else{$lavado="";}
								echo '<tr><td>'.$detalle[$x]["producto"].'</td><td>'.$detalle[$x]["estado"].'</td><td>'.$detalle[$x]["nsello"].'</td><td>'.$detalle[$x]["nbolsa"].'</td><td align="center">'.$detalle[$x]["abo"]."  ".$detalle[$x]["rh"].'</td><td align="center">'.$filtrada.'</td><td align="center">'.$irradiado.'</td><td align="center">'.$lavado.'</td><td align="center">'.$detalle[$x]["cantidad"].'</td><td align="center">'.$detalle[$x]["fechaextraccion"].'</td><td align="center">'.$detalle[$x]["fechav"].'</td></tr>';
							}
						?>
					</table>	
				</td>
			</tr>
			
			
			
			<tr><td><hr noshade="noshade" class="linea_egreso"></td></tr>
			<tr>
				<td align="center"><?php echo "Fecha y Hora de Impresion: ".date("d/m/Y")." - ".date("h:i a"); ?><br>HEMOTARIO</td>
			</tr>
		</table>
	</div>
	<!--<font id="eliminado" class="eliminado" <?php echo $anulado;?> >ANULADA</font>-->
</body>
</html>
