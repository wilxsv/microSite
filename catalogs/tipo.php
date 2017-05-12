<?php
global $wpdb;
$nombretipoherramienta="";
//Almacenando registros
if(isset($_POST["newtipoherramienta"])){
$nombretipoherramienta=$_POST["newnombretipoherramienta"];
//Comprobar que el registro no exista
$v=$wpdb->get_results(
		
				"select nombre from dgpc_tipoherramienta where nombre='".$nombretipoherramienta."'"
			
	);
if($wpdb->num_rows==0){
$r=$wpdb->query( 
	$wpdb->prepare( 
				"INSERT INTO dgpc_tipoherramienta (nombre) VALUES (%s)", 
     			$nombretipoherramienta) 
	);
	if($r==1){
		echo "
		<div>
  			<div class='alert alert-success'>
    			<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
    			<strong>Registro almacenado correctamente!</strong> 
    			
  			</div>
		</div>
	";
	}else{
		echo "
		<div>
  			<div class='alert alert-warning'>
    			<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
    			<strong>Se ha producido un error al intentar almacenar, compruebe los datos</strong> 
    			
  			</div>
		</div>
	";
	}
  }	
}
//Fin guardar registros
//Eliminando Reg
if(isset($_POST["deltipoherramienta"])){
$id=$_POST["delcodigotipoherramienta"];	
$wpdb->query( 
	$wpdb->prepare( 
				"delete FROM dgpc_tipoherramienta WHERE idtipo=%d", 
     			$id) 
	);
}
//fin eliminacion
//Actualizacion
if(isset($_POST["edittipoherramienta"])){
$id=$_POST["editcodigotipoherramienta"];
$nombretipoherramienta=$_POST["editnombretipoherramienta"];	
$wpdb->query( 
	$wpdb->prepare( 
				"UPDATE dgpc_tipoherramienta SET nombre=%s WHERE idtipo=%d", 
     			$nombretipoherramienta,$id) 
	);
}
//fin actualizacion
//consultando registros
$datostipoherramienta="";
$datostipoherramienta=$wpdb->get_results( 
		"select idtipo,nombre from dgpc_tipoherramienta order by nombre"    
	);
echo "
<script>
$(document).ready(function() {
// Select tab by name
$('.nav-tabs a[href=#".$tab."]').tab('show');
   $('#datostipoherramienta').DataTable();
   $('.borrartipoherramienta').click(function() {
   		$('#delcodigotipoherramienta').val($(this).val());
   		$('#ModalDeltipoherramienta').modal();
	});

	$('.editartipoherramienta').click(function() {
   		var datos=$(this).val().split('|');
   		$('#editcodigotipoherramienta').val(datos[0]);
   		$('#editnombretipoherramienta').val(datos[1]);
   		$('#ModalEdittipoherramienta').modal();
	});
} );
</script>
    <div role='tabpanel' class='tab-pane' id='tipo'>
	    <form role='form' name=ftipoherramienta1 method=post>
	    	 <div class='row'>
	    	 	<div class='col-xs-4'>
	    	 		<label for=newnombretipoherramienta>Tipo de herramienta</label>
	    	 	</div>
	    	 	<div class='col-xs-6'>
	    	 		<input type=hidden name=tab id=tab value='tipo'>		
	    			<input type=text name=newnombretipoherramienta id=newnombretipoherramienta class='form-control'> 
	        	</div>
	        	
				<button type='submit' class='btn btn-success' name=newtipoherramienta id=newtipoherramienta value='ok'>
					<span class='glyphicon glyphicon-plus'></span>
				</button>
	      	</div> 
	    </form>
	    </br>
	  
			<div class='table-responsive'>
				<table class='table table-hover table-bordered' id=datostipoherramienta>
					<thead>
					<tr>
						<th class='text-center'>Código</th>
						<th class='text-center'>
							Tipo de herramienta
						</th>
						<th class='text-center'>
							
						</th>
					</tr>
					<thead>
					<tbody>
					";

					if($datostipoherramienta!=""){
						foreach ($datostipoherramienta as $reg) {
							echo "
					<tr>
						<td class='text-center'>"
							.$reg->idtipo."
						</td>
						<td>".
							$reg->nombre."
						</td>
						<td>
							<button type='button' class='btn btn-success editartipoherramienta' name=editartipoherramienta id=editartipoherramienta value='".$reg->idtipo."|".$reg->nombre."'>
								<span class='glyphicon glyphicon-pencil'></span>
							</button>       
							
							<button type='button' class='btn btn-warning borrartipoherramienta' name=borrartipoherramienta id='borrartipoherramienta' value='".$reg->idtipo."'>
							<span class='glyphicon glyphicon-trash'></span>
							</button>
						</td>
					</tr>	
							";
						}
					}
					
				echo"</tbody>	
				</table>
	    	</div>
	 ";
 ?>
 	</div>

<div>
 <!-- Modal EDIT -->
  <div class="modal fade" id="ModalEdittipoherramienta" role="dialog"  tabindex="-1">
    <form role='form' name=ftipoherramienta2 method=post>
	    <div class="modal-dialog modal-sm" >
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">Edición de tipo de herramienta</h4>
	        </div>
	        <div class="modal-body">
		    	 	<div class='form-group'>
		    	 		<label for=editnombretipoherramienta>Nombre del tipo de herramienta</label>
		    	 		  <input type=hidden name=editcodigotipoherramienta id=editcodigotipoherramienta>
		    	 		  <input type=hidden name=tab id=tab value='tipo'>
		    	 		<input type=text required name=editnombretipoherramienta id=editnombretipoherramienta class='form-control'>             	
		      		</div> 
		    
	        </div>
	        <div class="modal-footer">
	        	<button type='submit' class='btn btn-success' name=edittipoherramienta id=edittipoherramienta value=ok>
					<span class='glyphicon glyphicon-ok'></span>
				</button>	
	          	<button type="button" class="btn btn-warning" data-dismiss="modal">
	          		<span class='glyphicon glyphicon-ban-circle'></span>	
	          	</button>
	        </div>
	      </div>
	    </div>
    </form>
  </div>
</div>  
<div>
 <!-- Modal DEL -->
  <div class="modal fade" id="ModalDeltipoherramienta" role="dialog"  tabindex="-1">
    <form role='form' name=ftipoherramienta3 method=post>
	    <div class="modal-dialog modal-sm" >
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title warning">¿confirme que desea eliminar el registro?</h4>
	          <input type=hidden name=delcodigotipoherramienta id=delcodigotipoherramienta>
	          <input type=hidden name=tab id=tab value='tipo'>
	        </div>
	        
	        <div class="modal-footer">
	        	<button type='submit' class='btn btn-success' name=deltipoherramienta value=ok>
					<span class='glyphicon glyphicon-ok'></span>
				</button>	
	          	<button type="button" class="btn btn-warning" data-dismiss="modal">
	          		<span class='glyphicon glyphicon-ban-circle'></span>	
	          	</button>
	        </div>
	      </div>
	    </div>
    </form>
  </div>
</div>  