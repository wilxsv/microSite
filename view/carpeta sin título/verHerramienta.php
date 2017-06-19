<?php
	global $wpdb;
	
	$query = "SELECT c.nombre AS clase, h.website, p.archivo, t.nombre AS tipo, o.nombre AS componente, h.fechaelaboracion, h.lugarelaboracion, i.nombre AS institucion,
				p.peso, p.idioma, h.objetivo, p.descripcion, p.portada, h.nombre
			FROM dgpc_herramienta AS h, dgpc_publicacion AS p, dgpc_claseherramienta AS c, dgpc_tipoherramienta AS t, dgpc_componente AS o, dgpc_institucion AS i
			WHERE h.idherramienta = p.idherramienta AND h.idclaseherramienta = c.idclase AND h.idcomponente = o.idcomponente AND
				h.idtipoherramienta = t.idtipo AND h.idinstitucionelaboro = i.idinstitucion AND h.idherramienta='".$_GET['herramienta']."';";
	$q=$wpdb->get_results( $query );
	foreach ($q as $i) { ?>
		<h2 ><?php echo $i->nombre; ?></h2>
		<hr>
		<p>
		 <center>
		  <img src="<?php echo $i->portada; ?>" alt="<?php echo $i->nombre; ?>" height="128" width="128" class="img-responsive img-thumbnail" align="center"/>
		 </center>
		</p>
		<p><b>Descripción : </b> <?php echo $i->descripcion; ?></p>
		<p><b>Objetivo : </b> <?php echo $i->objetivo; ?></p>
		<p><b>Idioma : </b> <?php echo $i->idioma; ?></p>
		<p><b>Peso : </b> <?php echo $i->peso; ?> Kb</p>
		<p><b>Institución que lo elaboró : </b> <?php echo $i->institucion; ?></p>
		<p><b>Lugar donde se desarrolló : </b> <?php echo $i->lugarelaboracion; ?></p>
		<p><b>Fecha de elaboración : </b> <?php echo $i->fechaelaboracion; ?></p>
		<p><b>Componente : </b> <?php echo $i->componente; ?></p>
		<p><b>Tipo de herramienta : </b> <?php echo $i->tipo; ?></p>
		<p><b>Clase de herramienta : </b> <?php echo $i->clase; ?></p>
		<p><b>Pagina web : </b> <?php echo $i->website; ?></p>
		<p><a href="<?php echo $i->archivo; ?>"><b>Descargar</b></a></p>
<?php } ?>

