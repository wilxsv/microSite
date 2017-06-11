<?php
 include WP_PLUGIN_DIR."/estadistica/shortCode/general.php";
  
 $datos_atts = shortcode_atts( array('anyo' => date("Y"), 'mes' => date("m"), 'orden' => 'ASC', 'titulo' => 6, 'maxdiv' => "400px"), $atts );
 $genera = TRUE;
 $div = "area";
 if (strlen($delito) < 5) $genera = TRUE ;
 $queryTotal = "SELECT sexo, area, COUNT(*) as total FROM victimas WHERE delito = '".$delito."' AND anyo = '".$datos_atts['anyo']."' GROUP BY sexo, area ORDER BY sexo, area";
 $queryX = "SELECT area FROM victimas WHERE delito = '".$delito."' AND anyo = '".$datos_atts['anyo']."' GROUP BY area ORDER BY area";
 $queryCategoria = "SELECT sexo FROM victimas WHERE delito = '".$delito."' AND anyo = '".$datos_atts['anyo']."' GROUP BY sexo ORDER BY sexo";
 $queryArma = "SELECT tipoarma, COUNT(*) as total FROM victimas WHERE delito = '".$delito."' AND anyo = '".$datos_atts['anyo']."' GROUP BY tipoarma ORDER BY tipoarma";
 
 $qSerie=$wpdb->get_results( $queryTotal );
 $qXLabel=$wpdb->get_results( $queryX );
 $qCategoria=$wpdb->get_results( $queryCategoria );
 $qArma=$wpdb->get_results( $queryArma );
 
 $series = '';
 $seriesP = '';
 foreach ($qCategoria as $l) {
	 $categoria.= "'$l->sexo',";
 }
 foreach ($qXLabel as $l) {
	 $labels.= "'$l->area',";
 }
 
 foreach ($qCategoria as $l) {
  $series.= "{ name:'$l->sexo', type:'bar', stack: '总量', itemStyle : { normal: {label : {show: true, position: 'inside'}}}, data:[";
  foreach ($qSerie as $d) {
   if ($l->sexo == $d->sexo)
    $series.= "$d->total,";
  }
  $series.= "]},"; 
 }

 if($genera){
  include WP_PLUGIN_DIR."/estadistica/shortCode/generaBarras.php";
 }
?>
