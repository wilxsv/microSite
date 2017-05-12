<?php
global $wpdb;
$nombreambito="";
//Almacenando registros
if(isset($_POST["newambito"])){
$nombreambito=$_POST["newnombreambito"];
//Comprobar que el registro no exista
$v=$wpdb->get_results(
		
				"select nombre from dgpc_ambitoaplicacion where nombre='".$nombreambito."'"
			
	);
if($wpdb->num_rows==0){
$r=$wpdb->query( 
	$wpdb->prepare( 
				"INSERT INTO dgpc_ambitoaplicacion (nombre) VALUES (%s)", 
     			$nombreambito) 
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
if(isset($_POST["delambito"])){
$id=$_POST["delcodigoambito"];	
$wpdb->query( 
	$wpdb->prepare( 
				"delete FROM dgpc_ambitoaplicacion WHERE idambito=%d", 
     			$id) 
	);
}
//fin eliminacion
//Actualizacion
if(isset($_POST["editambito"])){
$id=$_POST["editcodigoambito"];
$nombreambito=$_POST["editnombreambito"];	
$wpdb->query( 
	$wpdb->prepare( 
				"UPDATE dgpc_ambitoaplicacion SET nombre=%s WHERE idambito=%d", 
     			$nombreambito,$id) 
	);
}
//fin actualizacion
//consultando registros
$datosambito="";
$datosambito=$wpdb->get_results( 
		"select idambito,nombre from dgpc_ambitoaplicacion order by nombre"    
	);
echo "
<script>
$(document).ready(function() {
// Select tab by name
$('.nav-tabs a[href=#".$tab."]').tab('show');
   $('#datosambito').DataTable();
   $('.borrarambito').click(function() {
   		$('#delcodigoambito').val($(this).val());
   		$('#ModalDelAmbito').modal();
	});

	$('.editarambito').click(function() {
   		var datos=$(this).val().split('|');
   		$('#editcodigoambito').val(datos[0]);
   		$('#editnombreambito').val(datos[1]);
   		$('#ModalEditAmbito').modal();
	});
} );
</script>

    <div role='tabpanel' class='tab-pane' id='ambito'>
	    <form role='form' name=f1 method=post>
	    	 <div class='row'>
	    	 	<div class='col-xs-3'>
	    	 		<label for=newnombreambito>Nombre del ámbito de aplicación</label>
	    	 	</div>
	    	 	<div class='col-xs-6'>
	    	 		<input type=hidden name=tab id=tab value='ambito'>		
	    			<input type=text name=newnombreambito id=newnombreambito class='form-control'> 
	        	</div>
	        	
				<button type='submit' class='btn btn-success' name=newambito id=newambito value='ok'>
					<span class='glyphicon glyphicon-plus'></span>
				</button>
	      	</div> 
	    </form>
	    </br>
	  
			<div class='table-responsive'>
				<table class='table table-hover table-bordered' id=datosambito>
					<thead>
					<tr>
						<th class='text-center'>Código</th>
						<th class='text-center'>
							Nombre del ámbito. 
						</th>
						<th class='text-center'>
							
						</th>
					</tr>
					<thead>
					<tbody>
					";

					if($datosambito!=""){
						foreach ($datosambito as $reg) {
							echo "
					<tr>
						<td class='text-center'>"
							.$reg->idambito."
						</td>
						<td>".
							$reg->nombre."
						</td>
						<td>
							<button type='button' class='btn btn-success editarambito' name=editarambito id=editarambito value='".$reg->idambito."|".$reg->nombre."'>
								<span class='glyphicon glyphicon-pencil'></span>
							</button>       
							
							<button type='button' class='btn btn-warning borrarambito' name=borrarambito id='borrarambito' value='".$reg->idambito."'>
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
  <div class="modal fade" id="ModalEditAmbito" role="dialog"  tabindex="-1">
    <form role='form' name=f4 method=post>
	    <div class="modal-dialog modal-sm" >
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">Edición de ámbito de aplicación</h4>
	        </div>
	        <div class="modal-body">
		    	 	<div class='form-group'>
		    	 		<label for=editnombreambito>Ámbito de aplicación</label>
		    	 		  <input type=hidden name=editcodigoambito id=editcodigoambito>
		    	 		  <input type=hidden name=tab id=tab value='ambito'>
		    	 		<input type=text required name=editnombreambito id=editnombreambito class='form-control'>             	
		      		</div> 
		    
	        </div>
	        <div class="modal-footer">
	        	<button type='submit' class='btn btn-success' name=editambito id=editambito value=ok>
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
  <div class="modal fade" id="ModalDelAmbito" role="dialog"  tabindex="-1">
    <form role='form' name=f5 method=post>
	    <div class="modal-dialog modal-sm" >
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title warning">¿confirme que desea eliminar el registro?</h4>
	          <input type=hidden name=delcodigoambito id=delcodigoambito>
	          <input type=hidden name=tab id=tab value='ambito'>
	        </div>
	        
	        <div class="modal-footer">
	        	<button type='submit' class='btn btn-success' name=delambito value=ok>
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