<?php
 include WP_PLUGIN_DIR."/estadistica/shortCode/general.php";
  
 $datos_atts = shortcode_atts( array('anyo' => date("Y"), 'mes' => date("m"), 'orden' => 'ASC', 'titulo' => 6, 'maxdiv' => "400px"), $atts );
 $genera = TRUE;
 $div = "meses";
 if (strlen($delito) < 5) $genera = TRUE ;
 $queryMes = "SELECT mes, COUNT(*) as total FROM delitos WHERE delito = '".$delito."' AND anyo = '".$datos_atts['anyo']."' GROUP BY mes ORDER BY mes";
 
 $qSerie=$wpdb->get_results( $queryMes );

 $categoria = "'Meses'";
 $series.= "{ name:'Meses', type:'bar', stack: '总量', itemStyle : { normal: {label : {show: true, position: 'inside'}}}, data:[";
 foreach ($qSerie as $l) {
	 $serie[$l->mes].= "$l->total";
 }
 $series.= $serie['ENE'].",".$serie['FEB'].",".$serie['MAR'].",".$serie['ABR'].",".$serie['MAY'].",".$serie['JUN'].",".$serie['JUL'].",".$serie['SEP'].",".$serie['OCT'].",".$serie['NOV'].",".$serie['DIC']; 
 $series.= "]},"; 
 $labels = "'ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SEP','OCT','NOV','DIC',";
 if($genera){
  include WP_PLUGIN_DIR."/estadistica/shortCode/generaBarras.php";
 }
?>
