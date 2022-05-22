$(document).ready(inicializarEventos);
function inicializarEventos()
{
	inicio();
	cmd_buscar.click(buscar);
	btnAgendar.click(validarAgendamiento);

	newAdd.click(validarModal);
}
var idsede;
var iddonante_val=0;
var respuesta;
var idtipo;
var idtipod;
var tablaresp;
var idestado;
var fecha;
var obs;
var celular;
var ciudad;
var barrio;
var d;
var d1;
var d2;
var d3;
var d4;
var d5;
var d6;
var btnAgendar;
var tllamadas;
/*variables modal*/
var newName;
var newApe;
var newSexo;
var newTel;
var newDoc;
var newMail;
var newAdd;
/**/
function tipificacion()
{
	var num= prompt("DIGITE LA CEDULA");
	$.post("php/funciones_objs.php",{"op":"tipificacion","num":num},respuesta_tipificacion);
}
function respuesta_tipificacion(x)
{
	alert(x);
}
function respuesta_validarModal(x)
{
	alert(x);
	$(".modalCrearDonante").modal("hide");
	inicio();
}
function validarModal()
{
	limpiar_falta();
	if(newName.val()==""){falta(newName);return false;}
	if(newApe.val()==""){falta(newApe);return false;}
	if(newSexo.val()==""){falta(newSexo);return false;}
	if(newTel.val()==""){falta(newTel);return false;}
	if(newDoc.val()==""){falta(newDoc);return false;}
	if(newMail.val()==""){falta(newMail);return false;}
	//alert('Nombres:'+newName.val()+' '+newApe.val()+',Otros:'+newSexo.val()+','+newTel.val()+','+newDoc.val()+','+newMail.val());
	$.post("php/funciones_objs.php",{"op":"newDonante","name":newName.val(),"apellido":newApe.val(),"sexo":newSexo.val(),"tel":newTel.val(),"doc":newDoc.val(),"correo":newMail.val()},respuesta_validarModal);
}
function closeModal()
{
	$(".modal").fadeOut();
}
function nuevoDonante()
{
	$("#modalCrearDonante").modal("show");
}
/**/
function buscarindividual()
{
	$.post("../buscadonantesadmin/php/funciones_objs.php",{"op":"cargaindividual","cc":prompt("Escriba el numero de cedula a Importar:")},respuesta_carga);
}

function buscarReporte()
{
	limpiar_falta();
	if(idsede.val()<=0){falta(idsede);return false;}
	if($("#fechaRep").val()==""){falta($("#fechaRep"));return false;}
	window.open('../agendamientos_nuevo/?fechaReporte='+$("#fechaRep").val()+"&sede="+idsede.val(),'','width=800,height=400');
}
function validarAgendamiento()
{
	limpiar_falta();
	if(fecha.val()==""){falta(fecha);return false;}
	if($("#correo").val()==""){falta($("#correo"));return false;}
	window.open('../agendamientos_nuevo/?fecha='+fecha.val()+'&donante='+iddonante_val+'&correo='+$("#correo").val()+'&sede='+idsede.val(),'','width=800,height=400');
}
function consultadonante()
{
	conssihevi=window.open('../consulta_donantes/?c='+$("#ndocumento").val(),'','width=800,height=400');
}
function vercarga()
{
	var idsede = prompt("DIGITE LA SEDE");
	$.post("php/funciones_objs.php",{"op":"vercarga","idsede":idsede},respuesta_carga);
}
function carga()
{
	var desde = prompt("DIGITE LA FECHA DESDE");
	var hasta = prompt("DIGITE LA FECHA HASTA");
	var idsede = prompt("DIGITE LA SEDE");
	var abo = prompt("DIGITE ABO");
	var rh = prompt("DIGITE RH");
	$.post("php/funciones_objs.php",{"op":"carga","desde":desde,"hasta":hasta,"idsede":idsede,"abo":abo,"rh":rh},respuesta_carga);
}
function respuesta_carga(x)
{
	alert(x);
}
function aceptar()
{
	limpiar_falta();

	if(idestado.find(':selected').data("obliga")==1)
	{
		if(fecha.val().length<5)
		{
			falta(fecha);
			return false;
		}
		if($("#correo").val()=="")
		{
			falta($("#correo"));
			return false;
		}
		if(ciudad.val().length<5)
		{
			falta(ciudad);
			return false;
		}
		if(barrio.val().length<5)
		{
			falta(barrio);
			return false;
		}
		if(d.val()=='')
		{
			falta(d);
			return false;
		}
		if(d1.val().length<1)
		{
			falta(d1);
			return false;
		}
		if(d3.val().length<1)
		{
			falta(d3);
			return false;
		}
		if(d5.val().length<1)
		{
			falta(d5);
			return false;
		}
	}
	else if(idestado.find(':selected').data("obliga")==2)
	{
		if($("#correo").val()=="")
		{
			falta($("#correo"));
			return false;
		}
		if(ciudad.val().length<5)
		{
			falta(ciudad);
			return false;
		}
		if(barrio.val().length<5)
		{
			falta(barrio);
			return false;
		}
		if(d.val()=='')
		{
			falta(d);
			return false;
		}
		if(d1.val().length<1)
		{
			falta(d1);
			return false;
		}
		if(d3.val().length<1)
		{
			falta(d3);
			return false;
		}
		if(d5.val().length<1)
		{
			falta(d5);
			return false;
		}
	}
	$.post("php/funciones_objs.php",{"op":"aceptar","iddonante":iddonante_val,"idestado":idestado.val(),"fecha":fecha.val(),"obs":obs.val(),"ciudad":ciudad.val(),"barrio":barrio.val(),"d":d.val(),"d1":d1.val(),"d2":d2.val(),"d3":d3.val(),"d4":d4.val(),"d5":d5.val(),"d6":d6.val(),"correo":$("#correo").val()},respuesta_aceptar);
}
function respuesta_aceptar(x)
{
	if(x>0)
	{
		//buscar();
		$("modalReservaDonante").modal("hide");
		$("#d"+iddonante_val).hide();
		tablaresp.hide();
	}
	else
	{
		alert("OCURRIO UN ERROR, PULSE F5 E INTENTE DE NUEVO POR FAVOR");
	}
		
}
function seleccion(x,c,doc)
{
	limpiar_falta();
	obs.val(c.observacion);
	if(idsede.val()>0)
	{
		$("#ndocumento").val(doc);
		iddonante_val=x;
		fecha.val("");
		ciudad.val("");
		barrio.val("");
		d.val("");
		d1.val("");
		d2.val("");
		d3.val("");
		d4.val("");
		d5.val("");
		d6.val("");

		var contenido = `
			<div class='fw-bold' style='font-size:23px'>${c.nombre}</div>
			<div class='row border p-3 rounded-3 shadow-sm m-2 my-3'>
				<div class='col-6 p-0'>
					<div><b>Lugar:</b> ${c.lugar}</div>
					<div><b>Celular 1:</b> ${c.celulares[0]}</div>
					<div><b>Telefono casa:</b> ${c.celulares[3]}</div>
				</div>
				
				<div class='col-6 p-0'>
					<div><b>Última donación:</b> ${c.ultima_donacion}</div>
					<div><b>Celular 2:</b> ${c.celulares[1]}</div>
					<div><b>Telefono trabajo:</b> ${c.celulares[2]}</div>
				</div>
			</div>`;
		
		celular.html(contenido);

		$.post("php/funciones_objs.php",{"op":"seleccion","idd":x,"idtipo":idtipo.val()},respuesta_seleccion);
	}
	else
	{
		falta(idsede);
	}
	
}
function respuesta_seleccion(x)
{

	var datos = x.split("|");
	if(datos[1]>0)
	{
		idestado.html(datos[0]);
		$("#modalReservaDonante").modal("show");
		console.log("SE ABRIÓ LA MODAL");
		// tablaresp.show();
	}
	else
	{
		alert("ESA PERSONA YA LA ESTAN LLAMANDO, SELECCIONE OTRA POR FAVOR...");
	}
	
}
function cancelar()
{
	iddonante_val=0;
	$("#modalReservaDonante").modal("hide");
}
function inicio()
{
	idsede = $("#idsede");
	respuesta = $("#respuesta");
	idtipo = $("#idtipo");
	idtipod = $("#idtipod");
	tablaresp = $("#tablaresp");
	idestado = $("#idestado");
	fecha = $("#fecha");
	obs = $("#obs");
	celular = $("#celular");
	ciudad = $("#ciudad");
	barrio = $("#barrio");
	d = $("#d");
	d1 = $("#d1");
	d2 = $("#d2");
	d3 = $("#d3");
	d4 = $("#d4");
	d5 = $("#d5");
	d6 = $("#d6");
	btnAgendar = $("#btnAgendar");
	tllamadas = $("#tllamadas");
	/*variables modal*/
	newName = $("#newName");
	newApe = $("#newApe");
	newSexo = $("#newSexo");
	newTel = $("#newTel");
	newDoc = $("#newDoc");
	newMail = $("#newMail");
	newAdd = $("#newAdd");
	/*---------------*/
	$.post("php/funciones_objs.php",{"op":"inicio"},respuesta_inicio);
}
function respuesta_inicio(x)
{
	
	var obj = getJson(x);
	respuesta.html(obj.bloq);
	idtipo.html(obj.estados);
}
function buscar()
{
	limpiar_falta();
	if(idsede.val()<=0)
	{
		falta(idsede);
		return false;
	}
	
	//mensajes("",'red',0);
	procesando(true);
	
	$.post("php/funciones_objs.php",{"op":"buscar","idsede":idsede.val(),"idtipo":idtipo.val(),"idtipod":idtipod.val()},respuesta_buscar);
}
function respuesta_buscar(x)
{
	//alert(x);
	var obj = getJson(x);
	procesando(false)
	respuesta.html(obj.respuesta);
	tllamadas.html(obj.tllamadas);
	iddonante_val=0;
}
function crearexcel()
{
	reporte=window.open('','','width=800,height=400');
	reporte.document.write("<form action='php/excel.php' method = 'POST'><input type='hidden' name='export' value='"+respuesta.html()+"' /><input type ='submit' value='DESCARGAR ARCHIVO EN EXCEL' /></form>"+respuesta.html());
}