<?php 
/*wp-content/themes/presso/framework/redux-framework/ReduxCore/inc/class.redux_filesystem.php on line 131*/
include(plugin_dir_path( __FILE__ )."../catalogs/cabecera.php");
global $wpdb;
function normalize ($string) {
    $table = array(
        'Š'=>'S', 'š'=>'s', 'Ð'=>'Dj', 'Ž'=>'Z', 'ž'=>'z', 'C'=>'C', 'c'=>'c', 'C'=>'C', 'c'=>'c',
        'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
        'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
        'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
        'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
        'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
        'ÿ'=>'y', 'R'=>'R', 'r'=>'r',
    );

    return strtr($string, $table);
}  
  $last		= $wpdb->get_results( "SELECT * FROM pnc_hechos ORDER BY registro_hecho DESC LIMIT 1");
  $sql		= "SELECT d.nombre_departamento AS departamento, m.nombre_municipio AS municipio, de.nombre_delito AS delito, h.fecha_hecho AS fecha, s.nombre_sexo AS sexo
  FROM pnc_departamento AS d INNER JOIN pnc_municipio AS m ON m.departamento_id=d.id INNER JOIN pnc_hechos AS h ON h.municipio_hecho=m.id INNER JOIN pnc_delito AS de ON de.id=h.delito_hecho INNER JOIN pnc_sexo AS s ON s.id=h.sexo_hecho
  LIMIT 100";
  $hechos	= $wpdb->get_results( $sql);
?>
 <div class="card pressthis">
  <p>Conecxion a servidor restfull: <b>[Activa]</b></p>
  <p>Ultima connection: <b>[<?php  foreach ($last as $key => $object) { echo $object->registro_hecho; } ?>]</b></p>
  <p>Proxima connection: <b>[2017-06-12 03:00:00]</b></p>
  <p>
   <button type='button' title='Publicar' class='btn btn-success btn-xs publich' name=publich id=publich value="">
    <span class='glyphicon glyphicon-globe' data-toggle='tooltip' data-placement='top' title='Realizar volcado de datos desde servidor restFull'></span>
    Realizar volcado de datos desde servidor restFull
   </button>
  </p>
 </div>
<div class="wrap"> 
 <div class='table-responsive'>
  <h1>Listado de Cargas de datos (ultimos 100)</h1>
  <div class='table-responsive'>
        <table class='table table-hover table-bordered' id='datosherramienta'>
          <thead>
          <tr>
            <th class="text-center">Fuente</th>
            <th class="text-center">Departamento</th>
            <th class="text-center">Municipio</th>
            <th class="text-center">Delito</th>
            <th class="text-center">Sexo Victima</th>
            <th class="text-center">Fecha del hecho</th>
            </tr>
          </thead>
		 <tbody id="the-list">
			 <?php  
				foreach ($hechos as $key => $object) { 
					echo "<tr><td>Imperium</td><td>$object->departamento</td><td>$object->municipio</td><td>$object->delito</td><td>$object->sexo</td><td>$object->fecha</td></tr>";//$object->registro_hecho;
				} 
			 ?>
		 </tbody>
         <tfoot>
           <th class="manage-column">Fuente</th>
           <th class="manage-column">Departamento</th>
           <th class="manage-column">Municipio</th>
           <th class="manage-column">Delito</th>
           <th class="manage-column">Sexo Victima</th>
           <th class="manage-column">Fecha del hecho</th>
		 </tfoot>
        </table>
  </div>  
 </div>
</div>
  <script type="text/javascript">
 $('.publich').click(function() {

      $('#ModalPublicacion').modal();
      $('#idherramienta').val($(this).val());
  });
  $('.borrarpub').click(function(){
    $("#ModalDelPub").modal();
    $("#delcodigopublicacion").val($(this).val());
   
  });
 
jQuery(document).ready(function() {
 $.datepicker.regional['es'] = {
 closeText: 'Cerrar',
 prevText: '<Ant',
 nextText: 'Sig>',
 currentText: 'Hoy',
 monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
 monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
 dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
 dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
 dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
 weekHeader: 'Sm',
 dateFormat: 'dd/mm/yy',
 firstDay: 1,
 isRTL: false,
 showMonthAfterYear: false,
 changeMonth: true,
 changeYear: true, 
 yearSuffix: ''
 };
 $.datepicker.setDefaults($.datepicker.regional['es']);

    $("#pubInicio").datepicker();
    $('#pubFin').datepicker();
    $("#pubInicio").on("change", function (e) {
            $('#pubFin').datepicker('option', 'minDate', $(this).val()); 
        });
        $("#pubFin").on("change", function (e) {
            $('#pubInicio').datepicker('option', 'maxDate', $(this).val());
        });  
});
$("#pubPortada").on("change",function(){
  var ext=['gif','jpg','jpeg','png'];
  var v=$("#pubPortada").val().split('.').pop().toLowerCase();
  var valido=false;
    for(var i=0,n;n=ext[i];i++){
        if(n.toLowerCase()==v)
            valido=true
    }
   if(valido==false){
    alert('Formato de portada no válido');
    $("#pubPortada").val('');
   } 

});
$('[data-toggle="tooltip"]').tooltip(); 
 $('#datosherramienta').DataTable();
 
</script>
