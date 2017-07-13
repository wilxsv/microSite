<?php
 if ( ! defined( 'ABSPATH' ) ) exit;
 require_once( ABSPATH . '/wp-load.php' );
 global $wpdb;
 $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
 $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
 $mensaje_default = "Delitos contabilizados";
 
 $datos_atts = shortcode_atts( array('anyo' => date("Y"), 'mes' => date("m"), 'orden' => 'ASC', 'titulo' => 6, 'maxdiv' => "400px", 'sexo' => "MUJER"), $atts );
 $genera = TRUE;
 if (strlen($delito) < 5) $genera = TRUE ;
 
 $header = '<div class="row" style="text-align:center;"><h'.$datos_atts['titulo'].'>'.$mensaje_default.$mensaje.' de '. esc_attr( $datos_atts['anyo'] ) .'</h'.$datos_atts['titulo'].'></div>';
 echo $header;
?>
