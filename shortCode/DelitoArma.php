<?php
 include WP_PLUGIN_DIR."/estadistica/shortCode/general.php";
  
 $datos_atts = shortcode_atts( array('anyo' => date("Y"), 'mes' => date("m"), 'orden' => 'ASC', 'titulo' => 6, 'maxdiv' => "400px"), $atts );
 $genera = TRUE;
 $div = "arma";
 if (strlen($delito) < 5) $genera = TRUE ;
 $queryArma = "SELECT arma, COUNT(*) as total FROM delitos WHERE delito = '".$delito."' AND anyo = '".$datos_atts['anyo']."' GROUP BY arma ORDER BY arma";
 
 $qArma=$wpdb->get_results( $queryArma );
 
 $series = '';
 $series.= "{ name:'$delito', type:'pie', radius : '55%', center: ['50%', '60%'], data:[";
 foreach ($qArma as $l) {
  $categoria.= "'$l->arma',";
  $series.= "{value:$l->total, name:'$l->arma'},"; 
 }
 $series.= "]},"; 

 if($genera){
  include WP_PLUGIN_DIR."/estadistica/shortCode/generaPastel.php";
 }
?>
