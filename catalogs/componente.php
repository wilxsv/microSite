<?php
global $wpdb;
$nombrecomponente="";
$idarea="";
//Almacenando registros
if(isset($_POST["newcomponente"])){
$nombrecomponente=$_POST["newnombrecomponente"];
$idarea=$_POST["newareacomponente"];
//Comprobar que el registro no exista
$v=$wpdb->get_results(
		
				"select nombre from dgpc_componente where nombre='".$nombrecomponente."'"
			
	);
if($wpdb->num_rows==0){
$r=$wpdb->query( 
	$wpdb->prepare( 
				"INSERT INTO dgpc_componente (idarea,nombre) VALUES (%d,%s)", 
     			$idarea,$nombrecomponente) 
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
if(isset($_POST["delcomponente"])){
$id=$_POST["delcodigocomponente"];	
$wpdb->query( 
	$wpdb->prepare( 
				"delete FROM dgpc_componente WHERE idcomponente=%d", 
     			$id) 
	);
}
//fin eliminacion
//Actualizacion
if(isset($_POST["editcomponente"])){
$id=$_POST["editcodigocomponente"];
$idarea=$_POST["editareacomponente"];
$nombrecomponente=$_POST["editnombrecomponente"];	
$wpdb->query( 
	$wpdb->prepare( 
				"UPDATE dgpc_componente SET nombre=%s,idarea=%d WHERE idcomponente=%d", 
     			$nombrecomponente,$idarea,$id) 
	);
}
//fin actualizacion
//consultando registros
$datoscomponente="";
$datoscomponente=$wpdb->get_results( 
		"select dgpc_componente.idcomponente,dgpc_componente.nombre,dgpc_area.nombre as area
		  from dgpc_componente inner join dgpc_area on dgpc_componente.idarea=dgpc_area.idarea order by dgpc_componente.nombre, dgpc_area.nombre"    
	);

//consulta para llenar el select de areas
$areas=$wpdb->get_results( 
		"select idarea,nombre from dgpc_area order by nombre"    
	);
echo"
<script>
$(document).ready(function() {

$('.nav-tabs a[href=#".$tab."]').tab('show');
   $('#datoscomponente').DataTable();
   $('.borrarcomponente').click(function() {
   		$('#delcodigocomponente').val($(this).val());
   		$('#ModalDelcomponente').modal();
	});

	$('.editarcomponente').click(function() {
   		var datos=$(this).val().split('|');
   		$('#editcodigocomponente').val(datos[0]);
   		$('#editnombrecomponente').val(datos[1]);

   		
   		$('#editareacomponente option:contains('+datos[2]+')').prop('selected', true);
   		$('#ModalEditcomponente').modal();
	});
} );
</script>
    <div role='tabpanel' class='tab-pane' id='componente'>
	    <form role='form' name=fcomponente1 method=post>
	    	 <div class='row'>
	    	 	<div class='col-xs-2'>
	    	 		<label for=newnombrecomponente>Nombre del componente</label>
	    	 	</div>
	    	 	<div class='col-xs-3'>
	    	 		<input type=hidden name=tab id=tab value='componente'>		
	    			<input type=text name=newnombrecomponente id=newnombrecomponente class='form-control'> 
	        	</div>
	        	<select name=newareacomponente>
	        	";
	        	foreach ($areas as $opcion) {
	        	echo "
	        		<option value='".$opcion->idarea."'>".$opcion->nombre."</option>";
				}
	        	echo"	
	        	</select>
				<button type='submit' class='btn btn-success' name=newcomponente id=newcomponente value='ok'>
					<span class='glyphicon glyphicon-plus'></span>
				</button>
	      	</div> 
	    </form>
	    </br>
	  
			<div class='table-responsive'>
				<table class='table table-hover table-bordered' id=datoscomponente>
					<thead>
					<tr>
						<th class='text-center'>Código</th>
						<th class='text-center'>Área</th>
						<th class='text-center'>
							Nombre del componente. 
						</th>
						<th class='text-center'>
							
						</th>
					</tr>
					<thead>
					<tbody>
					";

					if($datoscomponente!=""){
						foreach ($datoscomponente as $reg) {
							echo "
					<tr>
						<td class='text-center'>"
							.$reg->idcomponente."
						</td>
						<td>".
							$reg->area."
						</td>
						<td>".
							$reg->nombre."
						</td>
						<td>
							<button type='button' class='btn btn-success editarcomponente' name=editarcomponente id=editarcomponente value='".$reg->idcomponente."|".$reg->nombre."|".$reg->area."'>
								<span class='glyphicon glyphicon-pencil'></span>
							</button>       
							
							<button type='button' class='btn btn-warning borrarcomponente' name=borrarcomponente id='borrarcomponente' value='".$reg->idcomponente."'>
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
  <div class="modal fade" id="ModalEditcomponente" role="dialog"  tabindex="-1">
    <form role='form' name=fcomponente2 method=post>
	    <div class="modal-dialog modal-sm" >
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">Actualización de componente</h4>
	        </div>
	        <div class="modal-body">
		    	 	<div class='form-group'>
		    	 		<label for=editnombrecomponente>Nombre del componente</label>
		    	 		  <input type=hidden name=editcodigocomponente id=editcodigocomponente>
		    	 		  <input type=hidden name=tab id=tab value='componente'>
		    	 		<input type=text required name=editnombrecomponente id=editnombrecomponente class='form-control'>             	
		      			</br>
		      			<label for=editareacomponente>Area:</label>
		      			<select name=editareacomponente id=editareacomponente>
				        <?php
				        	foreach ($areas as $opcion) {
				        	echo "
				        		<option value='".$opcion->idarea."'>".$opcion->nombre."</option>";
							}
				        ?>	
				        	</select>
		      		</div> 
		    
	        </div>
	        <div class="modal-footer">
	        	<button type='submit' class='btn btn-success' name=editcomponente id=editcomponente value=ok>
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
  <div class="modal fade" id="ModalDelcomponente" role="dialog"  tabindex="-1">
    <form role='form' name=fcomponente3 method=post>
	    <div class="modal-dialog modal-sm" >
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title warning">¿confirme que desea eliminar el registro?</h4>
	          <input type=hidden name=delcodigocomponente id=delcodigocomponente>
	          <input type=hidden name=tab id=tab value='componente'>
	        </div>
	        
	        <div class="modal-footer">
	        	<button type='submit' class='btn btn-success' name=delcomponente value=ok>
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