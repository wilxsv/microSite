<?php
 if ( ! defined( 'ABSPATH' ) ) exit;
 require_once( ABSPATH . '/wp-load.php' );
 global $wpdb;
 $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
 $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
 $mensaje_default = "Delitos contabilizados hasta el mes de ";
 
 if (strlen($mensaje) < 10) $mensaje = $mensaje_default ;
 
 $datos_atts = shortcode_atts( array('anyo' => date("Y"), 'mes' => date("m"), 'orden' => 'ASC', 'titulo' => 6), $atts );
 
 $header = '<div class="row"><h'.$datos_atts['titulo'].'>'.$mensaje.$meses[date($datos_atts['mes'])-1].' de '. esc_attr( $datos_atts['anyo'] ) .'</h'.$datos_atts['titulo'].'></div>';

	/*
	$query = "SELECT h.idherramienta AS id, c.nombre AS clase, h.website, p.archivo, t.nombre AS tipo, o.nombre AS componente, h.fechaelaboracion, h.lugarelaboracion, i.nombre AS institucion,
				p.peso, p.idioma, h.objetivo, p.descripcion, p.portada, h.nombre
			FROM dgpc_herramienta AS h, dgpc_publicacion AS p, dgpc_claseherramienta AS c, dgpc_tipoherramienta AS t, dgpc_componente AS o, 
			dgpc_institucion AS i, dgpc_grupoherramienta AS gh, dgpc_grupovulnerable AS g, dgpc_ambitoaplicacion AS a,
			dgpc_ambitoherramienta AS ah
			WHERE h.idherramienta = p.idherramienta AND h.idclaseherramienta = c.idclase AND h.idcomponente = o.idcomponente AND
				h.idtipoherramienta = t.idtipo AND h.idinstitucionelaboro = i.idinstitucion AND gh.idherramienta = h.idherramienta AND
				gh.idgrupo = g.idgrupo AND h.idherramienta = ah.idherramienta AND ah.idambito = a.idambito";
	if ($_POST['institucion'] > 0) { $query .= " AND h.idinstitucionelaboro = '".$_POST['institucion']."' "; }
	if ($_POST['clase'] > 0) { $query .= " AND h.idclaseherramienta = '".$_POST['clase']."' "; }
	if ($_POST['componente'] > 0) { $query .= " AND h.idcomponente = '".$_POST['componente']."' "; }
	if ($_POST['tipo'] > 0) { $query .= " AND h.idtipoherramienta = '".$_POST['tipo']."' "; }
	if ($_POST['ambito'] > 0) { $query .= " AND a.idambito = '".$_POST['ambito']."' "; }
	if ($_POST['grupo'] > 0) { $query .= " AND g.idgrupo = '".$_POST['grupo']."' "; }
	$query .= " ORDER BY h.fechaelaboracion ;";
	$q=$wpdb->get_results( $query );*/
	
 echo $header;
 $upload_dir = wp_upload_dir();
 $url = $upload_dir['baseurl'];
?>

<div class="row" style="text-align:center;">
 
</div>
