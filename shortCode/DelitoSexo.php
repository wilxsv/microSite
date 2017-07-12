<?php
 include WP_PLUGIN_DIR."/estadistica/shortCode/general.php";
  
 $datos_atts = shortcode_atts( array('anyo' => date("Y"), 'mes' => date("m"), 'orden' => 'ASC', 'titulo' => 6, 'maxdiv' => "400px", 'sexo' => "MUJER"), $atts );
 $genera = TRUE;
 $div = $datos_atts['sexo'];
 if (strlen($delito) < 5) $genera = TRUE ;
 $queryArma = "SELECT tipoarma, COUNT(*) as total FROM delitos WHERE delito = '".$delito."' AND anyo = '".$datos_atts['anyo']."' AND sexo = '".$datos_atts['sexo']."' GROUP BY tipoarma ORDER BY tipoarma";
 
 $qArma=$wpdb->get_results( $queryArma );
 
 $series = '';
 
 $series.= "{ name:'$delito', type:'pie', radius : '55%', center: ['50%', '60%'], data:[";
 foreach ($qArma as $l) {
  $categoria.= "'$l->tipoarma',";
  $series.= "{value:$l->total, name:'$l->tipoarma'},"; 
 }
 $series.= "]},"; 
 
 $delito.=' '.$datos_atts['sexo']; 
 if($genera){
  include WP_PLUGIN_DIR."/estadistica/shortCode/generaPastel.php";
 }
?>
