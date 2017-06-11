<?php
 include WP_PLUGIN_DIR."/estadistica/shortCode/general.php";
  
 $datos_atts = shortcode_atts( array('anyo' => date("Y"), 'mes' => date("m"), 'orden' => 'ASC', 'titulo' => 6, 'maxdiv' => "400px"), $atts );
 $genera = TRUE;
 if (strlen($delito) < 5) $genera = TRUE ;
 $queryArma = "SELECT tipoarma, COUNT(*) as total FROM victimas WHERE delito = '".$delito."' AND anyo = '".$datos_atts['anyo']."' GROUP BY tipoarma ORDER BY tipoarma";
 
 $qArma=$wpdb->get_results( $queryArma );
 
 $series = '';
 
 $series.= "{ name:'$delito', type:'pie', radius : '55%', center: ['50%', '60%'], data:[";
 foreach ($qArma as $l) {
  $categoria.= "'$l->tipoarma',";
  $series.= "{value:$l->total, name:'$l->tipoarma'},"; 
 }
 $series.= "]},"; 

 if($genera){
  include WP_PLUGIN_DIR."/estadistica/shortCode/generaPastel.php";
 }
?>
