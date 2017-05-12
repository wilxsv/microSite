<?php
global $wpdb;
$nombregrupo="";
//Almacenando registros
if(isset($_POST["newgrupo"])){
$nombregrupo=$_POST["newnombregrupo"];
//Comprobar que el registro no exista
$v=$wpdb->get_results(
		
				"select nombre from dgpc_grupovulnerable where nombre='".$nombregrupo."'"
			
	);
if($wpdb->num_rows==0){
$r=$wpdb->query( 
	$wpdb->prepare( 
				"INSERT INTO dgpc_grupovulnerable (nombre) VALUES (%s)", 
     			$nombregrupo) 
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
if(isset($_POST["delgrupo"])){
$id=$_POST["delcodigogrupo"];	
$wpdb->query( 
	$wpdb->prepare( 
				"delete FROM dgpc_grupovulnerable WHERE idgrupo=%d", 
     			$id) 
	);
}
//fin eliminacion
//Actualizacion
if(isset($_POST["editgrupo"])){
$id=$_POST["editcodigogrupo"];
$nombregrupo=$_POST["editnombregrupo"];	
$wpdb->query( 
	$wpdb->prepare( 
				"UPDATE dgpc_grupovulnerable SET nombre=%s WHERE idgrupo=%d", 
     			$nombregrupo,$id) 
	);
}
//fin actualizacion
//consultando registros
$datosgrupo="";
$datosgrupo=$wpdb->get_results( 
		"select idgrupo,nombre from dgpc_grupovulnerable order by nombre"    
	);
echo "
<script>
$(document).ready(function() {
// Select tab by name
$('.nav-tabs a[href=#".$tab."]').tab('show');
   $('#datosgrupo').DataTable();
   $('.borrargrupo').click(function() {
   		$('#delcodigogrupo').val($(this).val());
   		$('#ModalDelgrupo').modal();
	});

	$('.editargrupo').click(function() {
   		var datos=$(this).val().split('|');
   		$('#editcodigogrupo').val(datos[0]);
   		$('#editnombregrupo').val(datos[1]);
   		$('#ModalEditgrupo').modal();
	});
} );
</script>
    <div role='tabpanel' class='tab-pane' id='grupo'>
	    <form role='form' name=fgrupo1 method=post>
	    	 <div class='row'>
	    	 	<div class='col-xs-4'>
	    	 		<label for=newnombregrupo>Nombre del grupo</label>
	    	 	</div>
	    	 	<div class='col-xs-6'>
	    	 		<input type=hidden name=tab id=tab value='grupo'>		
	    			<input type=text name=newnombregrupo id=newnombregrupo class='form-control'> 
	        	</div>
	        	
				<button type='submit' class='btn btn-success' name=newgrupo id=newgrupo value='ok'>
					<span class='glyphicon glyphicon-plus'></span>
				</button>
	      	</div> 
	    </form>
	    </br>
	  
			<div class='table-responsive'>
				<table class='table table-hover table-bordered' id=datosgrupo>
					<thead>
					<tr>
						<th class='text-center'>Código</th>
						<th class='text-center'>
							Nombre del grupo 
						</th>
						<th class='text-center'>
							
						</th>
					</tr>
					<thead>
					<tbody>
					";

					if($datosgrupo!=""){
						foreach ($datosgrupo as $reg) {
							echo "
					<tr>
						<td class='text-center'>"
							.$reg->idgrupo."
						</td>
						<td>".
							$reg->nombre."
						</td>
						<td>
							<button type='button' class='btn btn-success editargrupo' name=editargrupo id=editargrupo value='".$reg->idgrupo."|".$reg->nombre."'>
								<span class='glyphicon glyphicon-pencil'></span>
							</button>       
							
							<button type='button' class='btn btn-warning borrargrupo' name=borrargrupo id='borrargrupo' value='".$reg->idgrupo."'>
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
  <div class="modal fade" id="ModalEditgrupo" role="dialog"  tabindex="-1">
    <form role='form' name=fgrupo2 method=post>
	    <div class="modal-dialog modal-sm" >
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">Edición de grupo vulnerable</h4>
	        </div>
	        <div class="modal-body">
		    	 	<div class='form-group'>
		    	 		<label for=editnombregrupo>Nombre del grupo vulnerable</label>
		    	 		  <input type=hidden name=editcodigogrupo id=editcodigogrupo>
		    	 		  <input type=hidden name=tab id=tab value='grupo'>
		    	 		<input type=text required name=editnombregrupo id=editnombregrupo class='form-control'>             	
		      		</div> 
		    
	        </div>
	        <div class="modal-footer">
	        	<button type='submit' class='btn btn-success' name=editgrupo id=editgrupo value=ok>
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
  <div class="modal fade" id="ModalDelgrupo" role="dialog"  tabindex="-1">
    <form role='form' name=fgrupo3 method=post>
	    <div class="modal-dialog modal-sm" >
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title warning">¿confirme que desea eliminar el registro?</h4>
	          <input type=hidden name=delcodigogrupo id=delcodigogrupo>
	          <input type=hidden name=tab id=tab value='grupo'>
	        </div>
	        
	        <div class="modal-footer">
	        	<button type='submit' class='btn btn-success' name=delgrupo value=ok>
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