<?php
 include WP_PLUGIN_DIR."/estadistica/shortCode/general.php";
  
 $datos_atts = shortcode_atts( array('anyo' => date("Y"), 'mes' => date("m"), 'orden' => 'ASC', 'titulo' => 6, 'maxdiv' => "400px"), $atts );
 $genera = TRUE;
 $div = "area";
 if (strlen($delito) < 5) $genera = TRUE ;
 $queryTotal = "SELECT area, COUNT(*) as total FROM delitos WHERE delito = '".$delito."' AND anyo = '".$datos_atts['anyo']."' GROUP BY area ORDER BY area";
 $queryX = "SELECT area FROM victimas WHERE delito = '".$delito."' AND anyo = '".$datos_atts['anyo']."' GROUP BY area ORDER BY area";
 $queryCategoria = "SELECT area FROM delitos WHERE delito = '".$delito."' AND anyo = '".$datos_atts['anyo']."' GROUP BY area ORDER BY area";
 $queryArma = "SELECT arma, COUNT(*) as total FROM delitos WHERE delito = '".$delito."' AND anyo = '".$datos_atts['anyo']."' GROUP BY arma ORDER BY arma";
 
 $qSerie=$wpdb->get_results( $queryTotal );
 $qXLabel=$wpdb->get_results( $queryX );
 $qCategoria=$wpdb->get_results( $queryCategoria );
 $qArma=$wpdb->get_results( $queryArma );
 
 $series = '';
 $seriesP = '';
 $categoria = '';
 foreach ($qSerie as $l) {
	 $categoria.= "'$l->area',";
	 $categoriaS.= "$l->total,";
 }
 
 foreach ($qXLabel as $l) {
	 $labels.= "'$l->area',";
 }
 
 foreach ($qCategoria as $l) {
  $series.= "{ name:'$l->area', type:'bar', data:[";
  foreach ($qSerie as $d) {
   $series.= "$d->total,";
  }
  $series.= "]},"; 
 }
 
 if($genera){
  include WP_PLUGIN_DIR."/estadistica/shortCode/generaBarras.php";
 }
?>
