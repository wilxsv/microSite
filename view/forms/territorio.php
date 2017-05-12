<div id="Map" style="width: 700px; height: 300px; margin: 0;"></div>
<script src="<?php echo get_site_url().'/wp-content/plugins/biblioteca/view/js/osm/'; ?>OpenLayers.js"></script>
<script>
    var lat            = 13.697911;
    var lon            = -89.218846;
    var zoom           = 8;
    var icoPng		   = '<?php echo get_site_url().'/wp-content/plugins/biblioteca/view/img/icoMap.png'; ?>';
    
    map = new OpenLayers.Map("Map");
    map.addLayer(new OpenLayers.Layer.OSM());
    
    epsg4326 =  new OpenLayers.Projection("EPSG:4326"); //WGS 1984 projection
    projectTo = map.getProjectionObject(); //The map projection (Spherical Mercator)
   
    var lonLat = new OpenLayers.LonLat( lon ,lat ).transform(epsg4326, projectTo);
    map.setCenter (lonLat, zoom);

    var vectorLayer = new OpenLayers.Layer.Vector("Overlay");
    
    // Define markers as "features" of the vector layer:
    <?php 
    global $wpdb;
	
	$query = "SELECT h.idherramienta AS id, c.nombre AS clase, h.website, p.archivo, t.nombre AS tipo, o.nombre AS componente, h.fechaelaboracion, h.lugarelaboracion, i.nombre AS institucion,
				p.peso, p.idioma, h.objetivo, p.descripcion, p.portada, h.nombre, X(h.coordenada) AS lon, Y(h.coordenada) AS lat
			FROM dgpc_herramienta AS h, dgpc_publicacion AS p, dgpc_claseherramienta AS c, dgpc_tipoherramienta AS t, dgpc_componente AS o, dgpc_institucion AS i
			WHERE h.idherramienta = p.idherramienta AND h.idclaseherramienta = c.idclase AND h.idcomponente = o.idcomponente AND
				h.idtipoherramienta = t.idtipo AND h.idinstitucionelaboro = i.idinstitucion 
			ORDER BY 6 DESC
			LIMIT 6;";
	$q=$wpdb->get_results( $query );
	
	foreach ($q as $i) {
		echo "
		var feature = new OpenLayers.Feature.Vector(
            new OpenLayers.Geometry.Point( ".$i->lon.", ".$i->lat." ).transform(epsg4326, projectTo),
            {description:'<a href=\"".site_url().'/index.php/buscar-herramienta?herramienta='.$i->id."\" ><b>".$i->nombre."</b></a><br/>".$i->descripcion."'} ,
            {externalGraphic: icoPng, graphicHeight: 30, graphicWidth: 28, graphicXOffset:-12, graphicYOffset:-25  }
        );    
    vectorLayer.addFeatures(feature);
    \n
		";
     }
    
    ?>
    
    var feature = new OpenLayers.Feature.Vector(
            new OpenLayers.Geometry.Point( -0.1244324, 51.5006728  ).transform(epsg4326, projectTo),
            {description:'Big Ben'} ,
            {externalGraphic: icoPng, graphicHeight: 25, graphicWidth: 21, graphicXOffset:-12, graphicYOffset:-25  }
        );    
    vectorLayer.addFeatures(feature);

    var feature = new OpenLayers.Feature.Vector(
            new OpenLayers.Geometry.Point( -0.119623, 51.503308  ).transform(epsg4326, projectTo),
            {description:'London Eye'} ,
            {externalGraphic: icoPng, graphicHeight: 25, graphicWidth: 21, graphicXOffset:-12, graphicYOffset:-25  }
        );    
    vectorLayer.addFeatures(feature);

   
    map.addLayer(vectorLayer);
 
    
    //Add a selector control to the vectorLayer with popup functions
    var controls = {
      selector: new OpenLayers.Control.SelectFeature(vectorLayer, { onSelect: createPopup, onUnselect: destroyPopup })
    };

    function createPopup(feature) {
      feature.popup = new OpenLayers.Popup.FramedCloud("pop",
          feature.geometry.getBounds().getCenterLonLat(),
          null,
          '<div class="markerContent">'+feature.attributes.description+'</div>',
          null,
          true,
          function() { controls['selector'].unselectAll(); }
      );
      //feature.popup.closeOnMove = true;
      map.addPopup(feature.popup);
    }

    function destroyPopup(feature) {
      feature.popup.destroy();
      feature.popup = null;
    }
    
    map.addControl(controls['selector']);
    controls['selector'].activate();
      
  </script>
