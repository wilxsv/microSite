<?php
global $wpdb;
$nombrepregunta="";
//Almacenando registros
if(isset($_POST["newpregunta"])){
$nombrepregunta=$_POST["newnombrepregunta"];
//Comprobar que el registro no exista
$v=$wpdb->get_results(
		
				"select pregunta from dgpc_preguntas where pregunta='".$nombrepregunta."'"
			
	);
if($wpdb->num_rows==0){
$r=$wpdb->query( 
	$wpdb->prepare( 
				"INSERT INTO dgpc_preguntas (pregunta) VALUES (%s)", 
     			$nombrepregunta) 
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
if(isset($_POST["delpregunta"])){
$id=$_POST["delcodigopregunta"];	
$wpdb->query( 
	$wpdb->prepare( 
				"delete FROM dgpc_preguntas WHERE idpregunta=%d", 
     			$id) 
	);
}
//fin eliminacion
//Actualizacion
if(isset($_POST["editpregunta"])){
$id=$_POST["editcodigopregunta"];
$nombrepregunta=$_POST["editnombrepregunta"];	
$wpdb->query( 
	$wpdb->prepare( 
				"UPDATE dgpc_preguntas SET pregunta=%s WHERE idpregunta=%d", 
     			$nombrepregunta,$id) 
	);
}
//fin actualizacion
//consultando registros
$datospregunta="";
$datospregunta=$wpdb->get_results( 
		"select idpregunta,pregunta from dgpc_preguntas order by pregunta"    
	);
echo "
<script>
$(document).ready(function() {
// Select tab by name
$('.nav-tabs a[href=#".$tab."]').tab('show');
   $('#datospregunta').DataTable();
   $('.borrarpregunta').click(function() {
   		$('#delcodigopregunta').val($(this).val());
   		$('#ModalDelpregunta').modal();
	});

	$('.editarpregunta').click(function() {
   		var datos=$(this).val().split('|');
   		$('#editcodigopregunta').val(datos[0]);
   		$('#editnombrepregunta').val(datos[1]);
   		$('#ModalEditpregunta').modal();
	});
} );
</script>
    <div role='tabpanel' class='tab-pane' id='pregunta'>
	    <form role='form' name=fpregunta1 method=post>
	    	 <div class='row'>
	    	 	<div class='col-xs-4'>
	    	 		<label for=newnombrepregunta>Interrogante</label>
	    	 	</div>
	    	 	<div class='col-xs-6'>
	    	 		<input type=hidden name=tab id=tab value='pregunta'>		
	    			<input type=text name=newnombrepregunta id=newnombrepregunta class='form-control'> 
	        	</div>
	        	
				<button type='submit' class='btn btn-success' name=newpregunta id=newpregunta value='ok'>
					<span class='glyphicon glyphicon-plus'></span>
				</button>
	      	</div> 
	    </form>
	    </br>
	  
			<div class='table-responsive'>
				<table class='table table-hover table-bordered' id=datospregunta>
					<thead>
					<tr>
						<th class='text-center'>Código</th>
						<th class='text-center'>
							Interrogante 
						</th>
						<th class='text-center'>
							
						</th>
					</tr>
					<thead>
					<tbody>
					";

					if($datospregunta!=""){
						foreach ($datospregunta as $reg) {
							echo "
					<tr>
						<td class='text-center'>"
							.$reg->idpregunta."
						</td>
						<td>".
							$reg->pregunta."
						</td>
						<td>
							<button type='button' class='btn btn-success editarpregunta' name=editarpregunta id=editarpregunta value='".$reg->idpregunta."|".$reg->pregunta."'>
								<span class='glyphicon glyphicon-pencil'></span>
							</button>       
							
							<button type='button' class='btn btn-warning borrarpregunta' name=borrarpregunta id='borrarpregunta' value='".$reg->idpregunta."'>
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
  <div class="modal fade" id="ModalEditpregunta" role="dialog"  tabindex="-1">
    <form role='form' name=fpregunta2 method=post>
	    <div class="modal-dialog modal-ls" >
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">Edición de aplicabilidad</h4>
	        </div>
	        <div class="modal-body">
		    	 	<div class='form-group'>
		    	 		<label for=editnombrepregunta>Interrogante</label>
		    	 		  <input type=hidden name=editcodigopregunta id=editcodigopregunta>
		    	 		  <input type=hidden name=tab id=tab value='pregunta'>
		    	 		<input type=text required name=editnombrepregunta id=editnombrepregunta class='form-control'>             	
		      		</div> 
		    
	        </div>
	        <div class="modal-footer">
	        	<button type='submit' class='btn btn-success' name=editpregunta id=editpregunta value=ok>
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
  <div class="modal fade" id="ModalDelpregunta" role="dialog"  tabindex="-1">
    <form role='form' name=fpregunta3 method=post>
	    <div class="modal-dialog modal-sm" >
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title warning">¿confirme que desea eliminar el registro?</h4>
	          <input type=hidden name=delcodigopregunta id=delcodigopregunta>
	          <input type=hidden name=tab id=tab value='pregunta'>
	        </div>
	        
	        <div class="modal-footer">
	        	<button type='submit' class='btn btn-success' name=delpregunta value=ok>
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