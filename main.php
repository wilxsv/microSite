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
add_shortcode('datosPNCTotalAreaAnyo', 'verTotalesDelitoAreaAnyo_shortcode' );
add_shortcode('datosPNCTotalArmaAnyo', 'verTotalesDelitoArmaAnyo_shortcode' );
add_shortcode('datosPNCTotalMesAnyo', 'verTotalesDelitoMesAnyo_shortcode' );/*
add_shortcode('datospnctotalareaanyo', 'verTotalesDelitoHombreAnyo_shortcode' );
add_shortcode('datospnctotalareaanyo', 'verTotalesDelitoLocalidadAnyo_shortcode' );
add_shortcode('datospnctotalareaanyo', 'verTotalesDelitoMujerAnyo_shortcode' );
*/
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

function verTotalesAnyo_shortcode($atts, $mensaje = null) {
	include WP_PLUGIN_DIR."/estadistica/shortCode/Resumen.php";
}
function verTotalesDelitoAreaAnyo_shortcode($atts, $delito = null) {
	include WP_PLUGIN_DIR."/estadistica/shortCode/DelitoArea.php";
}
function verTotalesDelitoArmaAnyo_shortcode($atts, $delito = null) {
	include WP_PLUGIN_DIR."/estadistica/shortCode/DelitoArma.php";
}
function verTotalesDelitoHombreAnyo_shortcode($atts, $delito = null) {
	include WP_PLUGIN_DIR."/estadistica/shortCode/DelitoHombre.php";
}
function verTotalesDelitoLocalidadAnyo_shortcode($atts, $delito = null) {
	include WP_PLUGIN_DIR."/estadistica/shortCode/DelitoLocalidad.php";
}
function verTotalesDelitoMesAnyo_shortcode($atts, $delito = null) {
	include WP_PLUGIN_DIR."/estadistica/shortCode/DelitoMes.php";
}
function verTotalesDelitoMujerAnyo_shortcode($atts, $delito = null) {
	include WP_PLUGIN_DIR."/estadistica/shortCode/DelitoMujer.php";
}
?>
