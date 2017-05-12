<?php
global $wpdb;
$nombrecontacto="";
//Almacenando registros
if(isset($_POST["newcontacto"])){
$nombrecontacto=$_POST["newnombrecontacto"];
$cargocontacto=$_POST["newcargocontacto"];
$telefonocontacto=$_POST["newtelefonocontacto"];
$emailcontacto=$_POST["newemailcontacto"];
$websitecontacto=$_POST["newwebsitecontacto"];
$r=$wpdb->query( 
	$wpdb->prepare( 
				"INSERT INTO dgpc_contacto (nombre,cargo,telefono,email,website) VALUES (%s,%s,%s,%s,%s)", 
     			$nombrecontacto,$cargocontacto,$telefonocontacto,$emailcontacto,$websitecontacto) 
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
if(isset($_POST["delcontacto"])){
$id=$_POST["delcodigocontacto"];	
$wpdb->query( 
	$wpdb->prepare( 
				"delete FROM dgpc_contacto WHERE idcontacto=%d", 
     			$id) 
	);
}
//fin eliminacion
//Actualizacion
if(isset($_POST["editcontacto"])){
$id=$_POST["editcodigocontacto"];
$nombrecontacto=$_POST["editnombrecontacto"];
$cargocontacto=$_POST["editcargocontacto"];
$telefonocontacto=$_POST["edittelefonocontacto"];
$emailcontacto=$_POST["editemailcontacto"];
$websitecontacto=$_POST["editwebsitecontacto"];	
$wpdb->query( 
	$wpdb->prepare( 
				"UPDATE dgpc_contacto SET nombre=%s, cargo=%s, telefono=%s, email=%s, website=%s WHERE idcontacto=%d", 
     			$nombrecontacto,$cargocontacto,$telefonocontacto,$emailcontacto,$websitecontacto ,$id) 
	);
}
//fin actualizacion
//consultando registros
$datoscontacto="";
$datoscontacto=$wpdb->get_results( 
		"select idcontacto,nombre,cargo,telefono,email,website from dgpc_contacto order by nombre"    
	);
echo "
<script>
$(document).ready(function() {
// Select tab by name
$('.nav-tabs a[href=#".$tab."]').tab('show');
   $('#datoscontacto').DataTable();
   $('.borrarcontacto').click(function() {
   		$('#delcodigocontacto').val($(this).val());
   		$('#ModalDelcontacto').modal();
	});

	$('.editarcontacto').click(function() {
   		var datos=$(this).val().split('|');
   		$('#editcodigocontacto').val(datos[0]);
   		$('#editnombrecontacto').val(datos[1]);
   		$('#editcargocontacto').val(datos[2]);
   		$('#edittelefonocontacto').val(datos[3]);
   		$('#editemailcontacto').val(datos[4]);
   		$('#editwebsitecontacto').val(datos[5]);
   		$('#ModalEditcontacto').modal();
	});
} );
</script>
    <div role='tabpanel' class='tab-pane' id='contacto'>
	    <form role='form' name=fcontacto1 method=post>
	    	 <div class='form-group col-md-5'>
	    	 	<label for=newnombrecontacto>Nombre</label>
	    	 	<input type=hidden name=tab id=tab value='contacto'>		
	    		<input type=text name=newnombrecontacto id=newnombrecontacto class='form-control' required> 
	        </div>
	        <div class='form-group col-md-4'>
	        	<label for=newcargocontacto>Cargo</label>
	        	<input type=text name=newcargocontacto id=newcargocontacto class='form-control' required> 
	        </div>
	        <div class='form-group col-md-2'>
	        	<label for=newtelefonocontacto>Teléfono</label>
	        	<input type=text name=newtelefonocontacto id=newtelefonocontacto class='form-control' required> 
	        </div>
	        <div class='form-group col-md-6'>
	        	<label for=newemailcontacto>Correo electrónico</label>
	        	<input type=email name=newemailcontacto id=newemailcontacto class='form-control' required> 
	        </div>
	        <div class='form-group col-md-6'>
	        	<label for=newwebsitecontacto>Dirección de sitio web</label>
	        	<input type=url name=newwebsitecontacto id=newwebsitecontacto class='form-control' required> 
	        </div>
	        <div class='form-group col-md-1'>
				<button type='submit' class='btn btn-success' name=newcontacto id=newcontacto value='ok'>
					<span class='glyphicon glyphicon-plus'></span>
				</button>
			</div>		
	    </form>
	    <div class='clear'></div>
	    </br>
	  
			<div class='table-responsive'>
				<table class='table table-hover table-bordered' id=datoscontacto>
					<thead>
					<tr>
						<th class='text-center'>Código</th>
						<th class='text-center'>
							Nombre
						</th>
						<th class='text-center'>
							Cargo
						</th>
						<th class='text-center'>
							Teléfono
						</th>
						<th class='text-center'>
							Email
						</th>
						<th class='text-center'>
							Website
						</th>
						<th class='text-center'>
							
						</th>
					</tr>
					<thead>
					<tbody>
					";

					if($datoscontacto!=""){
						foreach ($datoscontacto as $reg) {
							echo "
					<tr>
						<td class='text-center'>"
							.$reg->idcontacto."
						</td>
						<td>".
							$reg->nombre."
						</td>
						<td>".
							$reg->cargo."
						</td>
						<td>".
							$reg->telefono."
						</td>
						<td>".
							$reg->email."
						</td>
						<td>".
							$reg->website."
						</td>
						<td>
							<button type='button' class='btn btn-success editarcontacto' name=editarcontacto id=editarcontacto value='".$reg->idcontacto."|".$reg->nombre."|".$reg->cargo."|".$reg->telefono."|".$reg->email."|".$reg->website."'>
								<span class='glyphicon glyphicon-pencil'></span>
							</button>       
							
							<button type='button' class='btn btn-warning borrarcontacto' name=borrarcontacto id='borrarcontacto' value='".$reg->idcontacto."'>
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
  <div class="modal fade" id="ModalEditcontacto" role="dialog"  tabindex="-1">
    <form role='form' name=fcontacto2 method=post>
	    <div class="modal-dialog modal-sm" >
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">Actualización de Contactos</h4>
	        </div>
	        <div class="modal-body">
		    	 	<div class='form-group'>
		    	 		<label for=editnombrecontacto>Nombre del Contacto</label>
		    	 		  <input type=hidden name=editcodigocontacto id=editcodigocontacto>
		    	 		  <input type=hidden name=tab id=tab value='contacto'>
		    	 		<input type=text required name=editnombrecontacto id=editnombrecontacto class='form-control'>             	
		      		</div> 
					<div class='form-group'>
	        			<label for=editcargocontacto>Cargo</label>
	        			<input type=text name=editcargocontacto id=editcargocontacto class='form-control' required> 
	        		</div>
			        <div class='form-group'>
			        	<label for=edittelefonocontacto>Teléfono</label>
			        	<input type=text name=edittelefonocontacto id=edittelefonocontacto class='form-control' required> 
			        </div>
			        <div class='form-group'>
			        	<label for=editemailcontacto>Correo electrónico</label>
			        	<input type=email name=editemailcontacto id=editemailcontacto class='form-control' required> 
			        </div>
			        <div class='form-group'>
			        	<label for=editwebsitecontacto>Dirección de sitio web</label>
			        	<input type=url name=editwebsitecontacto id=editwebsitecontacto class='form-control' required> 
			        </div>		    
	        </div>
	        <div class="modal-footer">
	        	<button type='submit' class='btn btn-success' name=editcontacto id=editcontacto value=ok>
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
  <div class="modal fade" id="ModalDelcontacto" role="dialog"  tabindex="-1">
    <form role='form' name=fcontacto3 method=post>
	    <div class="modal-dialog modal-sm" >
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title warning">¿confirme que desea eliminar el registro?</h4>
	          <input type=hidden name=delcodigocontacto id=delcodigocontacto>
	          <input type=hidden name=tab id=tab value='contacto'>
	        </div>
	        
	        <div class="modal-footer">
	        	<button type='submit' class='btn btn-success' name=delcontacto value=ok>
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