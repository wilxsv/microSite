<?php
global $wpdb;
$nombreclase="";
//Almacenando registros
if(isset($_POST["newclase"])){
$nombreclase=$_POST["newnombreclase"];
//Comprobar que el registro no exista
$v=$wpdb->get_results(
		
				"select nombre from dgpc_claseherramienta where nombre='".$nombreclase."'"
			
	);
if($wpdb->num_rows==0){
$r=$wpdb->query( 
	$wpdb->prepare( 
				"INSERT INTO dgpc_claseherramienta (nombre) VALUES (%s)", 
     			$nombreclase) 
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
if(isset($_POST["delclase"])){
$id=$_POST["delcodigoclase"];	
$wpdb->query( 
	$wpdb->prepare( 
				"delete FROM dgpc_claseherramienta WHERE idclase=%d", 
     			$id) 
	);
}
//fin eliminacion
//Actualizacion
if(isset($_POST["editclase"])){
$id=$_POST["editcodigoclase"];
$nombreclase=$_POST["editnombreclase"];	
$wpdb->query( 
	$wpdb->prepare( 
				"UPDATE dgpc_claseherramienta SET nombre=%s WHERE idclase=%d", 
     			$nombreclase,$id) 
	);
}
//fin actualizacion
//consultando registros
$datosclase="";
$datosclase=$wpdb->get_results( 
		"select idclase,nombre from dgpc_claseherramienta order by nombre"    
	);
echo "
<script>
$(document).ready(function() {
// Select tab by name
$('.nav-tabs a[href=#".$tab."]').tab('show');
   $('#datosclase').DataTable();
   $('.borrarclase').click(function() {
   		$('#delcodigoclase').val($(this).val());
   		$('#ModalDelclase').modal();
	});

	$('.editarclase').click(function() {
   		var datos=$(this).val().split('|');
   		$('#editcodigoclase').val(datos[0]);
   		$('#editnombreclase').val(datos[1]);
   		$('#ModalEditclase').modal();
	});
} );
</script>
    <div role='tabpanel' class='tab-pane' id='clase'>
	    <form role='form' name=fclase1 method=post>
	    	 <div class='row'>
	    	 	<div class='col-xs-4'>
	    	 		<label for=newnombreclase>Nombre de la clase de herramienta</label>
	    	 	</div>
	    	 	<div class='col-xs-6'>
	    	 		<input type=hidden name=tab id=tab value='clase'>		
	    			<input type=text name=newnombreclase id=newnombreclase class='form-control'> 
	        	</div>
	        	
				<button type='submit' class='btn btn-success' name=newclase id=newclase value='ok'>
					<span class='glyphicon glyphicon-plus'></span>
				</button>
	      	</div> 
	    </form>
	    </br>
	  
			<div class='table-responsive'>
				<table class='table table-hover table-bordered' id=datosclase>
					<thead>
					<tr>
						<th class='text-center'>Código</th>
						<th class='text-center'>
							Nombre de la clase. 
						</th>
						<th class='text-center'>
							
						</th>
					</tr>
					<thead>
					<tbody>
					";

					if($datosclase!=""){
						foreach ($datosclase as $reg) {
							echo "
					<tr>
						<td class='text-center'>"
							.$reg->idclase."
						</td>
						<td>".
							$reg->nombre."
						</td>
						<td>
							<button type='button' class='btn btn-success editarclase' name=editarclase id=editarclase value='".$reg->idclase."|".$reg->nombre."'>
								<span class='glyphicon glyphicon-pencil'></span>
							</button>       
							
							<button type='button' class='btn btn-warning borrarclase' name=borrarclase id='borrarclase' value='".$reg->idclase."'>
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
  <div class="modal fade" id="ModalEditclase" role="dialog"  tabindex="-1">
    <form role='form' name=fclase2 method=post>
	    <div class="modal-dialog modal-sm" >
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">Edición de clase de herramientas</h4>
	        </div>
	        <div class="modal-body">
		    	 	<div class='form-group'>
		    	 		<label for=editnombreclase>Nombre de la clase de herramienta</label>
		    	 		  <input type=hidden name=editcodigoclase id=editcodigoclase>
		    	 		  <input type=hidden name=tab id=tab value='clase'>
		    	 		<input type=text required name=editnombreclase id=editnombreclase class='form-control'>             	
		      		</div> 
		    
	        </div>
	        <div class="modal-footer">
	        	<button type='submit' class='btn btn-success' name=editclase id=editclase value=ok>
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
  <div class="modal fade" id="ModalDelclase" role="dialog"  tabindex="-1">
    <form role='form' name=fclase3 method=post>
	    <div class="modal-dialog modal-sm" >
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title warning">¿confirme que desea eliminar el registro?</h4>
	          <input type=hidden name=delcodigoclase id=delcodigoclase>
	          <input type=hidden name=tab id=tab value='clase'>
	        </div>
	        
	        <div class="modal-footer">
	        	<button type='submit' class='btn btn-success' name=delclase value=ok>
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