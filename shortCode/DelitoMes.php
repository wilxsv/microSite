<?php
 include WP_PLUGIN_DIR."/estadistica/shortCode/general.php";
  
 $datos_atts = shortcode_atts( array('anyo' => date("Y"), 'mes' => date("m"), 'orden' => 'ASC', 'titulo' => 6, 'maxdiv' => "400px"), $atts );
 $genera = TRUE;
 $div = "meses";
 if (strlen($delito) < 5) $genera = TRUE ;
 $queryMes = "SELECT mes, COUNT(*) as total FROM delitos WHERE delito = '".$delito."' AND anyo = '".$datos_atts['anyo']."' GROUP BY mes ORDER BY mes";
 
 $qSerie=$wpdb->get_results( $queryMes );

 $categoria = "'Meses'";
 $series.= "{ name:'Meses', type:'bar', data:[";
 foreach ($qSerie as $l) {
	 $serie[$l->mes].= "$l->total";
 }
 $series.= $serie['ENE'].",".$serie['FEB'].",".$serie['MAR'].",".$serie['ABR'].",".$serie['MAY'].",".$serie['JUN'].",".$serie['JUL'].",".$serie['AGO'].",".$serie['SEP'].",".$serie['OCT'].",".$serie['NOV'].",".$serie['DIC']; 
 $series.= "]},"; 
 $categoriaS = $series;
 $labels = "'ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SEP','OCT','NOV','DIC',";
 
?>
<div class="row" style="text-align:center;">
 <div class="row">
  <div id="meses" style="height:<?php echo $datos_atts['maxdiv']; ?>"></div>
 </div>
</div>
<script src="<?php echo plugin_dir_url( __FILE__ ); ?>../js/echarts-2.2.7/build/dist/echarts.js"></script>
<script type="text/javascript">
 require.config({ paths: { echarts: '<?php echo plugin_dir_url( __FILE__ ); ?>../js/echarts-2.2.7/build/dist' } });
 require( [ 'echarts', 'echarts/chart/bar' ],
  function (ec) {
   var myChart = ec.init(document.getElementById('meses')); 
   var option = {
	   title : { text: '', subtext: '' },
	   tooltip : { trigger: 'axis', axisPointer : { type : 'shadow' } },
	   toolbox: {
        show : false, orient: 'vertical', x: 'right', y: 'center',
        feature : { mark : {show: true}, dataView : {show: true, readOnly: false, title : 'Ver datos'}, magicType : {show: true, type: []}, restore : {show: true, title : 'Reiniciar'}, saveAsImage : {show: true, title : 'Guardar como imagen'} }
       },
       calculable : true,
	   yAxis : [ { type : 'value' } ],
	   xAxis : [ { type : 'category', data : ['ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SEP','OCT','NOV','DIC',] } ],
	   series : [<?php echo $series; ?>]
   };
  myChart.setOption(option);
 });
</script>
