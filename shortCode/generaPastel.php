<div class="row" style="text-align:center;">
 <div class="row">
  <div id="<?php echo $div; ?>" style="height:<?php echo $datos_atts['maxdiv']; ?>"></div>
 </div>
</div>
<script src="<?php echo plugin_dir_url( __FILE__ ); ?>../js/echarts-2.2.7/build/dist/echarts.js"></script>
<script type="text/javascript">
 require.config({ paths: { echarts: '<?php echo plugin_dir_url( __FILE__ ); ?>../js/echarts-2.2.7/build/dist' } });
 require( [ 'echarts', 'echarts/chart/pie' ],
  function (ec) {
   var myChart = ec.init(document.getElementById('<?php echo $div; ?>')); 
   var option = {
	   title : { text: 'Delito: <?php echo $delito; ?>', subtext: 'Conteo hasta <?php echo $meses[date($datos_atts['mes'])-1]; ?>' },
	   tooltip : { trigger: 'item', formatter: "{a} <br/>{b} : {c} ({d}%)" },
	   toolbox: {
        show : true, orient: 'vertical', x: 'right', y: 'center',
        feature : { mark : {show: true}, dataView : {show: true, readOnly: false, title : 'Ver datos'}, restore : {show: true, title : 'Reiniciar'}, saveAsImage : {show: true, title : 'Guardar como imagen'} }
       },
       calculable : true,
	   /*Agregado dinamicamente*/
	   legend: { data:[<?php echo $categoria; ?>] },
	   series : [<?php echo $series; ?>]
	   
   };
  myChart.setOption(option);
 });
</script>
