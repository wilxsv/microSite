<?php
	global $wpdb;
	
	$query = "SELECT h.idherramienta AS id, c.nombre AS clase, h.website, p.archivo, t.nombre AS tipo, o.nombre AS componente, h.fechaelaboracion, h.lugarelaboracion, i.nombre AS institucion,
				p.peso, p.idioma, h.objetivo, p.descripcion, p.portada, h.nombre
			FROM dgpc_herramienta AS h, dgpc_publicacion AS p, dgpc_claseherramienta AS c, dgpc_tipoherramienta AS t, dgpc_componente AS o, dgpc_institucion AS i
			WHERE h.idherramienta = p.idherramienta AND h.idclaseherramienta = c.idclase AND h.idcomponente = o.idcomponente AND
				h.idtipoherramienta = t.idtipo AND h.idinstitucionelaboro = i.idinstitucion 
			ORDER BY 6 DESC
			LIMIT 6;";
	$q=$wpdb->get_results( $query );
	foreach ($q as $i) { ?>
		<h3><?php echo $i->nombre; ?></h3>
		<p>
			<img src="<?php echo $i->portada; ?>" alt="<?php echo $i->nombre; ?>" height="64" width="64" class="img-responsive img-thumbnail" align="left"/>
			<?php echo $i->descripcion; ?><br />
			<b>Objetivo : </b><?php echo $i->objetivo; ?><br />
			<b>Componente : </b> <?php echo $i->componente; ?><br />
			<b>Tipo de herramienta : </b> <?php echo $i->tipo; ?><br />
			<a href="<?php site_url().'/index.php/buscar-herramienta'; ?>?herramienta=<?php echo $i->id ?>"><b>Leer más y descargar </b></a>
		</p>
		<hr>
<?php } ?>
