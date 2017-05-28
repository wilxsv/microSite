<?php
/*
Plugin Name: Micro sitio de estadisticas
Description: Administración de banco de datos.
Author: [Policia Nacional Civil.]
Version: 0.6
*/
register_activation_hook( __FILE__, 'createDB' );
add_action('admin_menu', 'setup_menu');
add_shortcode('datospnctotalanyo', 'verTotalesAnyo_shortcode' );

function createDB(){
	include('load.php');
}
function setup_menu(){

	require('setupMenu.php'); 
}
//the_content
/**********************************************************************
 *  Views and Widgets
 * *******************************************************************/
function listadoHerramienta()	{ require('view/listHerramienta.php'); }
function viewContent()			{ include('view/contentSearch.php'); }
include("view/lateralSearch.php");
$lateralView = new LateralView();
/**********************************************************************
 *  Shortcode
 * *******************************************************************/
function mostrarMapaHerramientas_shortcode() {
	include WP_PLUGIN_DIR."/estadistica/view/forms/territorio.php";
}
function verHerramienta_shortcode() {
	include WP_PLUGIN_DIR."/estadistica/view/verHerramienta.php";
}
function verTotalesAnyo_shortcode($atts, $mensaje = null) {
	include WP_PLUGIN_DIR."/estadistica/control/shortCodeResumen.php";
}
?>
