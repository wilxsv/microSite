<?php
global $wpdb;
$nombrearea="";
//Almacenando registros
if(isset($_POST["newarea"])){
$nombrearea=$_POST["newnombrearea"];
//Comprobar que el registro no exista
$v=$wpdb->get_results(
		
				"select nombre from dgpc_area where nombre='".$nombrearea."'"
			
	);
if($wpdb->num_rows==0){
$r=$wpdb->query( 
	$wpdb->prepare( 
				"INSERT INTO dgpc_area (nombre) VALUES (%s)", 
     			$nombrearea) 
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
if(isset($_POST["delarea"])){
$id=$_POST["delcodigoarea"];	
$wpdb->query( 
	$wpdb->prepare( 
				"delete FROM dgpc_area WHERE idarea=%d", 
     			$id) 
	);
}
//fin eliminacion
//Actualizacion
if(isset($_POST["editarea"])){
$id=$_POST["editcodigoarea"];
$nombrearea=$_POST["editnombrearea"];	
$wpdb->query( 
	$wpdb->prepare( 
				"UPDATE dgpc_area SET nombre=%s WHERE idarea=%d", 
     			$nombrearea,$id) 
	);
}
//fin actualizacion
//consultando registros
$datosarea="";
$datosarea=$wpdb->get_results( 
		"select idarea,nombre from dgpc_area order by nombre"    
	);
echo "
<script>
$(document).ready(function() {
// Select tab by name
$('.nav-tabs a[href=#".$tab."]').tab('show');
   $('#datosarea').DataTable();
   $('.borrararea').click(function() {
   		$('#delcodigoarea').val($(this).val());
   		$('#ModalDelarea').modal();
	});

	$('.editararea').click(function() {
   		var datos=$(this).val().split('|');
   		$('#editcodigoarea').val(datos[0]);
   		$('#editnombrearea').val(datos[1]);
   		$('#ModalEditarea').modal();
	});
} );
</script>
    <div role='tabpanel' class='tab-pane' id='area'>
	    <form role='form' name=farea1 method=post>
	    	 <div class='row'>
	    	 	<div class='col-xs-4'>
	    	 		<label for=newnombrearea>Nombre del área de aplicación</label>
	    	 	</div>
	    	 	<div class='col-xs-6'>
	    	 		<input type=hidden name=tab id=tab value='area'>		
	    			<input type=text name=newnombrearea id=newnombrearea class='form-control'> 
	        	</div>
	        	
				<button type='submit' class='btn btn-success' name=newarea id=newarea value='ok'>
					<span class='glyphicon glyphicon-plus'></span>
				</button>
	      	</div> 
	    </form>
	    </br>
	  
			<div class='table-responsive'>
				<table class='table table-hover table-bordered' id=datosarea>
					<thead>
					<tr>
						<th class='text-center'>Código</th>
						<th class='text-center'>
							Nombre del área 
						</th>
						<th class='text-center'>
							
						</th>
					</tr>
					<thead>
					<tbody>
					";

					if($datosarea!=""){
						foreach ($datosarea as $reg) {
							echo "
					<tr>
						<td class='text-center'>"
							.$reg->idarea."
						</td>
						<td>".
							$reg->nombre."
						</td>
						<td>
							<button type='button' class='btn btn-success editararea' name=editararea id=editararea value='".$reg->idarea."|".$reg->nombre."'>
								<span class='glyphicon glyphicon-pencil'></span>
							</button>       
							
							<button type='button' class='btn btn-warning borrararea' name=borrararea id='borrararea' value='".$reg->idarea."'>
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
  <div class="modal fade" id="ModalEditarea" role="dialog"  tabindex="-1">
    <form role='form' name=farea2 method=post>
	    <div class="modal-dialog modal-sm" >
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">Actualización de áreas</h4>
	        </div>
	        <div class="modal-body">
		    	 	<div class='form-group'>
		    	 		<label for=editnombrearea>Nombre del área</label>
		    	 		  <input type=hidden name=editcodigoarea id=editcodigoarea>
		    	 		  <input type=hidden name=tab id=tab value='area'>
		    	 		<input type=text required name=editnombrearea id=editnombrearea class='form-control'>             	
		      		</div> 
		    
	        </div>
	        <div class="modal-footer">
	        	<button type='submit' class='btn btn-success' name=editarea id=editarea value=ok>
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
  <div class="modal fade" id="ModalDelarea" role="dialog"  tabindex="-1">
    <form role='form' name=farea3 method=post>
	    <div class="modal-dialog modal-sm" >
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title warning">¿confirme que desea eliminar el registro?</h4>
	          <input type=hidden name=delcodigoarea id=delcodigoarea>
	          <input type=hidden name=tab id=tab value='area'>
	        </div>
	        
	        <div class="modal-footer">
	        	<button type='submit' class='btn btn-success' name=delarea value=ok>
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