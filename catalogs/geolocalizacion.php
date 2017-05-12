<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.css" />
<!-- Modal Mapa -->

 <div class="modal" id="ModalMapa" role="dialog" tabindex="-1"> 
	  	<div class="modal-dialog">
	        <div class="modal-content">
	          <div class="modal-header">
	            <button type="button" class="close" data-dismiss="modal">&times;</button>
	            <h4 class="modal-title">Geolocalización</h4>
	          </div>
	          <div class="modal-body">
				<div id="map" style="width:100%; height: 250px"></div>
			  </div>	
			 <div class="modal-footer">
	            <button type="button"  class='btn btn-success' name='savepoint' id='savepoint' value='ok'>
	          		<span class='glyphicon glyphicon-ok'>Asignar Coordenadas</span>
	        	</button> 
	            <button type="button" class="btn btn-warning" data-dismiss="modal">
	               <span class='glyphicon glyphicon-ban-circle'>Cancelar</span>  
	            </button>
	          </div>
	        </div>  	
	  	</div>
</div> 
<?php echo"<script src='".plugin_dir_url( __FILE__ )."../js/app.js'></script>";?>
 	
