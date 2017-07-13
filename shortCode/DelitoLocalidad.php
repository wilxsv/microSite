<?php
 include WP_PLUGIN_DIR."/estadistica/shortCode/general.php";
  
 $datos_atts = shortcode_atts( array('anyo' => date("Y"), 'mes' => date("m"), 'orden' => 'ASC', 'titulo' => 6, 'maxdiv' => "400px", 'sexo' => "MUJER"), $atts );
 $genera = TRUE;
 $div = "mapa".$delito;
 
 $query = "SELECT departamento, COUNT(*) as total FROM delitos WHERE delito = '".$delito."' AND anyo = '".$datos_atts['anyo']."' GROUP BY departamento ORDER BY departamento";
 $q=$wpdb->get_results( $query );
 
 echo '<table class="" cellspacing="0"><thead><tr><th title="delitos.departamento">departamento</th><th title="">total</th></tr></thead><tbody>';
 foreach ($q as $l) {
  echo "<tr><td>$l->departamento</td><td>$l->total</td></tr>"; 
 }
 echo '</tbody></table>
';

?>

