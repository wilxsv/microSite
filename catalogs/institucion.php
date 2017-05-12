<?php
global $wpdb;
$nombre="";
//Almacenando registros
if(isset($_POST["nuevo"])){
$nombre=$_POST["nombre"];
$r=$wpdb->query( 
	$wpdb->prepare( 
				"INSERT INTO dgpc_institucion (nombre) VALUES (%s)", 
     			$nombre) 
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
//Fin guardar registros
//Eliminando Reg
if(isset($_POST["delete"])){
$id=$_POST["codigodelete"];	
$wpdb->query( 
	$wpdb->prepare( 
				"DELETE FROM dgpc_institucion WHERE idinstitucion=%d", 
     			$id) 
	);
}
//fin eliminacion
//Actualizacion
if(isset($_POST["nombreedit"])){
$id=$_POST["codigo"];
$nombre=$_POST["nombreedit"];	
$wpdb->query( 
	$wpdb->prepare( 
				"UPDATE dgpc_institucion SET nombre=%s WHERE idinstitucion=%d", 
     			$nombre,$id) 
	);
}
//fin actualizacion
//consultando registros
$datos="";
$datos=$wpdb->get_results( 
		"select idinstitucion,nombre from dgpc_institucion order by nombre"    
	);
echo "
<script>
$(document).ready(function() {
   $('#datos').DataTable();
   $('.borrar').click(function() {
     	
   $('#codigodelete').val($(this).val());
   $('#ModalDelete').modal();
	});

	$('.editar').click(function() {
   var datos=$(this).val().split('|');
   $('#codigo').val(datos[0]);
   $('#nombreedit').val(datos[1]);
   $('#ModalEdit').modal();
	});
} );
</script>
    <div role='tabpanel' class='tab-pane' id='institucion'>
	    <form role='form' name=f1 method=post>
	    	 <div class='row'>
	    	 	<div class='col-xs-3'>
	    	 		<label for=nombre>Nombre de Institución</label>
	    	 	</div>
	    	 	<div class='col-xs-6'>		
	    			<input type=text name=nombre id=nombre class='form-control'> 
	    			<input type=hidden name=tab id=tab value='institucion'>
	        	</div>
	        	<button type='submit' class='btn btn-success' name=nuevo id=nuevo value='ok'>
					<span class='glyphicon glyphicon-plus'></span>
				</button>
	      	</div> 
	    </form>
	    </br>
	  
			<div class='table-responsive'>
				<table class='table table-hover table-bordered' id=datos>
					<thead>
					<tr>
						<th class='text-center'>Código</th>
						<th class='text-center'>
							Nombre de la institución / Persona
						</th>
						<th class='text-center'>
							
						</th>
					</tr>
					<thead>
					<tbody>
					";

					if($datos!=""){
						foreach ($datos as $reg) {
							echo "
					<tr>
						<td class='text-center'>"
							.$reg->idinstitucion."
						</td>
						<td>".
							$reg->nombre."
						</td>
						<td>
							<button type='button' class='btn btn-success editar' name=editar id=editar value='".$reg->idinstitucion."|".$reg->nombre."'>
								<span class='glyphicon glyphicon-pencil'></span>
							</button>       
							
							<button type='button' class='btn btn-warning borrar' name=borrar id='borrar' value='".$reg->idinstitucion."'>
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
  <div class="modal fade" id="ModalEdit" role="dialog"  tabindex="-1">
    <form role='form' name=f4 method=post>
	    <div class="modal-dialog modal-sm" >
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">Actualización de instituciones</h4>
	        </div>
	        <div class="modal-body">
		    	 	<div class='form-group'>
		    	 		<label for=nombre>Nombre de Institución</label>
		    	 		  <input type=hidden name=codigo id=codigo>
		    	 		  <input type=hidden name=tab id=tab value='institucion'>
		    	 		<input type=text required name=nombreedit id=nombreedit class='form-control' value='<?php echo $nombre;?>'>             	
		      		</div> 
		    
	        </div>
	        <div class="modal-footer">
	        	<button type='submit' class='btn btn-success' name=edit id=edit value=ok>
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
 <!-- Modal DELETE -->
  <div class="modal fade" id="ModalDelete" role="dialog"  tabindex="-1">
    <form role='form' name=f5 method=post>
	    <div class="modal-dialog modal-sm" >
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title warning">¿confirme que desea eliminar el registro?</h4>
	          <input type=hidden name=codigodelete id=codigodelete>
	          <input type=hidden name=tab id=tab value='institucion'>
	        </div>
	        
	        <div class="modal-footer">
	        	<button type='submit' class='btn btn-success' name=delete value=ok>
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