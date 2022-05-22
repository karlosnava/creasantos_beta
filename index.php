<?php

require_once("../../general/creasantos/creasantos.php");
$objs = new creaSantos;
$objs->setSession();
$objs->setRuta("../../");

$objs->setCssGeneral("bootstrap/bootstrap.min");
$objs->setCssGeneral("sweetalert2.min");
$objs->setJsGeneral("bootstrap/bootstrap.bundle.min");
$objs->setJsGeneral("sweetalert2.min");

$objs->setJs("funciones_objv6");
$objs->setTitulo("Busca Donantes | Plataforma FUHECO");
$objs->setVista("objs");

$objs->setCssGeneral("fondo");
$objs->setCssGeneral("botones");
$objs->setCss("style1");
// $objs->setCssGeneral("contenido");
// $objs->setCssGeneral("funciones");

$objs->jsaRecorte("mensaje");
$objs->jsaRecorte("cmd_buscar");
// $objs->jsaRecorte("rangofecha");
$objs->jsaRecorte("respuestabuscar");

echo $objs->render();

/*
	145 - REQUISITOS
	1. EN LA OBSERVCION AÑADIRLO AL MODAL LISTO
	2. EN RESULTADO QUE APAREZCA LO DE TIPO DE DONANTE
	3. LOS Q ESTAN EN ROJO DESBLOQUARLOS Y DEJARLOS EN CONFIRMADOS
*/
