<?php
global $wpdb;
$nombreincluye="";
//Almacenando registros
if(isset($_POST["newincluye"])){
$nombreincluye=$_POST["newnombreincluye"];
//Comprobar que el registro no exista
$v=$wpdb->get_results(
		
				"select nombre from dgpc_itemincluye where nombre='".$nombreincluye."'"
			
	);
if($wpdb->num_rows==0){
$r=$wpdb->query( 
	$wpdb->prepare( 
				"INSERT INTO dgpc_itemincluye (nombre) VALUES (%s)", 
     			$nombreincluye) 
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
if(isset($_POST["delincluye"])){
$id=$_POST["delcodigoincluye"];	
$wpdb->query( 
	$wpdb->prepare( 
				"delete FROM dgpc_itemincluye WHERE iditem=%d", 
     			$id) 
	);
}
//fin eliminacion
//Actualizacion
if(isset($_POST["editincluye"])){
$id=$_POST["editcodigoincluye"];
$nombreincluye=$_POST["editnombreincluye"];	
$wpdb->query( 
	$wpdb->prepare( 
				"UPDATE dgpc_itemincluye SET nombre=%s WHERE iditem=%d", 
     			$nombreincluye,$id) 
	);
}
//fin actualizacion
//consultando registros
$datosincluye="";
$datosincluye=$wpdb->get_results( 
		"select iditem,nombre from dgpc_itemincluye order by nombre"    
	);
echo "
<script>
$(document).ready(function() {
// Select tab by name
$('.nav-tabs a[href=#".$tab."]').tab('show');
   $('#datosincluye').DataTable();
   $('.borrarincluye').click(function() {
   		$('#delcodigoincluye').val($(this).val());
   		$('#ModalDelincluye').modal();
	});

	$('.editarincluye').click(function() {
   		var datos=$(this).val().split('|');
   		$('#editcodigoincluye').val(datos[0]);
   		$('#editnombreincluye').val(datos[1]);
   		$('#ModalEditincluye').modal();
	});
} );
</script>
    <div role='tabpanel' class='tab-pane' id='incluye'>
	    <form role='form' name=fincluye1 method=post>
	    	 <div class='row'>
	    	 	<div class='col-xs-4'>
	    	 		<label for=newnombreincluye>Campo de acción</label>
	    	 	</div>
	    	 	<div class='col-xs-6'>
	    	 		<input type=hidden name=tab id=tab value='incluye'>		
	    			<input type=text name=newnombreincluye id=newnombreincluye class='form-control'> 
	        	</div>
	        	
				<button type='submit' class='btn btn-success' name=newincluye id=newincluye value='ok'>
					<span class='glyphicon glyphicon-plus'></span>
				</button>
	      	</div> 
	    </form>
	    </br>
	  
			<div class='table-responsive'>
				<table class='table table-hover table-bordered' id=datosincluye>
					<thead>
					<tr>
						<th class='text-center'>Código</th>
						<th class='text-center'>
							Campo de acción 
						</th>
						<th class='text-center'>
							
						</th>
					</tr>
					<thead>
					<tbody>
					";

					if($datosincluye!=""){
						foreach ($datosincluye as $reg) {
							echo "
					<tr>
						<td class='text-center'>"
							.$reg->iditem."
						</td>
						<td>".
							$reg->nombre."
						</td>
						<td>
							<button type='button' class='btn btn-success editarincluye' name=editarincluye id=editarincluye value='".$reg->iditem."|".$reg->nombre."'>
								<span class='glyphicon glyphicon-pencil'></span>
							</button>       
							
							<button type='button' class='btn btn-warning borrarincluye' name=borrarincluye id='borrarincluye' value='".$reg->iditem."'>
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
  <div class="modal fade" id="ModalEditincluye" role="dialog"  tabindex="-1">
    <form role='form' name=fincluye2 method=post>
	    <div class="modal-dialog modal-sm" >
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">Edición de campos de acción</h4>
	        </div>
	        <div class="modal-body">
		    	 	<div class='form-group'>
		    	 		<label for=editnombreincluye>Campo de acción</label>
		    	 		  <input type=hidden name=editcodigoincluye id=editcodigoincluye>
		    	 		  <input type=hidden name=tab id=tab value='incluye'>
		    	 		<input type=text required name=editnombreincluye id=editnombreincluye class='form-control'>             	
		      		</div> 
		    
	        </div>
	        <div class="modal-footer">
	        	<button type='submit' class='btn btn-success' name=editincluye id=editincluye value=ok>
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
  <div class="modal fade" id="ModalDelincluye" role="dialog"  tabindex="-1">
    <form role='form' name=fincluye3 method=post>
	    <div class="modal-dialog modal-sm" >
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title warning">¿confirme que desea eliminar el registro?</h4>
	          <input type=hidden name=delcodigoincluye id=delcodigoincluye>
	          <input type=hidden name=tab id=tab value='incluye'>
	        </div>
	        
	        <div class="modal-footer">
	        	<button type='submit' class='btn btn-success' name=delincluye value=ok>
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