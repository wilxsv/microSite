<?php
/*
Plugin Name: Micro sitio de estadisticas
Description: Administración de banco de datos.
Author: [Policia Nacional Civil.]
Version: 0.6
*/
register_activation_hook( __FILE__, 'createDB' );
add_action('admin_menu', 'setup_menu');
add_action('admin_menu', 'setup_menu');
add_action('wp_ajax_get_instituciones', 'ajax_get_instituciones');
add_action('wp_ajax_insert_institucion', 'ajax_insert_institucion');
add_shortcode('mapaHerramientas', 'mostrarMapaHerramientas_shortcode');
add_shortcode('verHerramienta', 'verHerramienta_shortcode');

function createDB(){
	include('load.php');
}
function setup_menu(){

	require('setupMenu.php'); 
}
 
function FormHerramientas(){
	require('catalogs/formularioHerramienta.php');
}
	
function loadArea(){
	require('area.php');
} 
function parametros(){

	include('catalogs/catalogos.php');
}

function ajax_get_instituciones(){
	global $wpdb;
	$instituciones=$wpdb->get_results( 
		"select dgpc_institucion.idinstitucion,dgpc_institucion.nombre from dgpc_institucion order by dgpc_institucion.nombre"    
		);
	$return=array();
	$p=0;
	foreach ($instituciones as $value) {
		$return[$p]=array('value' =>  $value->idinstitucion, 'nombre'=>$value->nombre);
		$p++;
	}
	wp_send_json($return);
	
	
}
function ajax_insert_institucion(){
	global $wpdb;
	$return=array();
	if(isset($_POST["nombre"])){
  		$seleccionpresenta= $_POST["nombre"];
		  $r=$wpdb->query( 
		  $wpdb->prepare( 
		        "INSERT INTO dgpc_institucion (nombre) VALUES (%s)", 
		         $seleccionpresenta) 
		  		);
		  $return[0]=array("result"=>'success');
	}
	wp_send_json($return);

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
	include WP_PLUGIN_DIR."/biblioteca/view/forms/territorio.php";
}
function verHerramienta_shortcode() {
	include WP_PLUGIN_DIR."/biblioteca/view/verHerramienta.php";
}
?>
