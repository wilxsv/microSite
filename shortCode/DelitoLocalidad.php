<?php
 include WP_PLUGIN_DIR."/estadistica/shortCode/general.php";
  
 $datos_atts = shortcode_atts( array('anyo' => date("Y"), 'mes' => date("m"), 'orden' => 'ASC', 'titulo' => 6, 'maxdiv' => "400px", 'sexo' => "MUJER"), $atts );
 $genera = TRUE;
 $div = "mapa".$delito;
 if (strlen($delito) < 5) $genera = TRUE ;
 if($genera){
  include WP_PLUGIN_DIR."/estadistica/shortCode/generaMapa.php";
 }
?>

