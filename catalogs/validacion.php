<?php
global $wpdb;
$nombrecriterio="";
//Almacenando registros
if(isset($_POST["newcriterio"])){
$nombrecriterio=$_POST["newnombrecriterio"];
//Comprobar que el registro no exista
$v=$wpdb->get_results(
		
				"select nombre from dgpc_criteriovalidacion where nombre='".$nombrecriterio."'"
			
	);
if($wpdb->num_rows==0){
$r=$wpdb->query( 
	$wpdb->prepare( 
				"INSERT INTO dgpc_criteriovalidacion (nombre) VALUES (%s)", 
     			$nombrecriterio) 
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
if(isset($_POST["delcriterio"])){
$id=$_POST["delcodigocriterio"];	
$wpdb->query( 
	$wpdb->prepare( 
				"delete FROM dgpc_criteriovalidacion WHERE idcriterio=%d", 
     			$id) 
	);
}
//fin eliminacion
//Actualizacion
if(isset($_POST["editcriterio"])){
$id=$_POST["editcodigocriterio"];
$nombrecriterio=$_POST["editnombrecriterio"];	
$wpdb->query( 
	$wpdb->prepare( 
				"UPDATE dgpc_criteriovalidacion SET nombre=%s WHERE idcriterio=%d", 
     			$nombrecriterio,$id) 
	);
}
//fin actualizacion
//consultando registros
$datoscriterio="";
$datoscriterio=$wpdb->get_results( 
		"select idcriterio,nombre from dgpc_criteriovalidacion order by nombre"    
	);
echo "
<script>
$(document).ready(function() {
// Select tab by name
$('.nav-tabs a[href=#".$tab."]').tab('show');
   $('#datoscriterio').DataTable();
   $('.borrarcriterio').click(function() {
   		$('#delcodigocriterio').val($(this).val());
   		$('#ModalDelcriterio').modal();
	});

	$('.editarcriterio').click(function() {
   		var datos=$(this).val().split('|');
   		$('#editcodigocriterio').val(datos[0]);
   		$('#editnombrecriterio').val(datos[1]);
   		$('#ModalEditcriterio').modal();
	});
} );
</script>
    <div role='tabpanel' class='tab-pane' id='validacion'>
	    <form role='form' name=fcriterio1 method=post>
	    	 <div class='row'>
	    	 	<div class='col-xs-4'>
	    	 		<label for=newnombrecriterio>Nombre del criterio</label>
	    	 	</div>
	    	 	<div class='col-xs-6'>
	    	 		<input type=hidden name=tab id=tab value='validacion'>		
	    			<input type=text name=newnombrecriterio id=newnombrecriterio class='form-control'> 
	        	</div>
	        	
				<button type='submit' class='btn btn-success' name=newcriterio id=newcriterio value='ok'>
					<span class='glyphicon glyphicon-plus'></span>
				</button>
	      	</div> 
	    </form>
	    </br>
	  
			<div class='table-responsive'>
				<table class='table table-hover table-bordered table-condensed' id=datoscriterio>
					<thead>
					<tr>
						<th class='text-center'>Código</th>
						<th class='text-center'>
							Nombre del criterio 
						</th>
						<th class='text-center'>
							
						</th>
					</tr>
					<thead>
					<tbody>
					";

					if($datoscriterio!=""){
						foreach ($datoscriterio as $reg) {
							echo "
					<tr>
						<td class='text-center'>"
							.$reg->idcriterio."
						</td>
						<td>".
							$reg->nombre."
						</td>
						<td>
							<button type='button' class='btn btn-success editarcriterio' name=editarcriterio id=editarcriterio value='".$reg->idcriterio."|".$reg->nombre."'>
								<span class='glyphicon glyphicon-pencil'></span>
							</button>       
							
							<button type='button' class='btn btn-warning borrarcriterio' name=borrarcriterio id='borrarcriterio' value='".$reg->idcriterio."'>
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
  <div class="modal fade" id="ModalEditcriterio" role="dialog"  tabindex="-1">
    <form role='form' name=fcriterio2 method=post>
	    <div class="modal-dialog modal-sm" >
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">Edición criterios de validación</h4>
	        </div>
	        <div class="modal-body">
		    	 	<div class='form-group'>
		    	 		<label for=editnombrecriterio>Nombre del criterio de validación</label>
		    	 		  <input type=hidden name=editcodigocriterio id=editcodigocriterio>
		    	 		  <input type=hidden name=tab id=tab value='validacion'>
		    	 		<input type=text required name=editnombrecriterio id=editnombrecriterio class='form-control'>             	
		      		</div> 
		    
	        </div>
	        <div class="modal-footer">
	        	<button type='submit' class='btn btn-success' name=editcriterio id=editcriterio value=ok>
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
  <div class="modal fade" id="ModalDelcriterio" role="dialog"  tabindex="-1">
    <form role='form' name=fcriterio3 method=post>
	    <div class="modal-dialog modal-sm" >
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title warning">¿confirme que desea eliminar el registro?</h4>
	          <input type=hidden name=delcodigocriterio id=delcodigocriterio>
	          <input type=hidden name=tab id=tab value='criterio'>
	        </div>
	        
	        <div class="modal-footer">
	        	<button type='submit' class='btn btn-success' name=delcriterio value=ok>
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