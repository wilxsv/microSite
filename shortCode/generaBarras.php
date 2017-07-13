<div class="row" style="text-align:center;">
 <div class="row">
  <div id="<?php echo $div; ?>" style="height:<?php echo $datos_atts['maxdiv']; ?>"></div>
 </div>
</div>
<script src="<?php echo plugin_dir_url( __FILE__ ); ?>../js/echarts-2.2.7/build/dist/echarts.js"></script>
<script type="text/javascript">
 require.config({ paths: { echarts: '<?php echo plugin_dir_url( __FILE__ ); ?>../js/echarts-2.2.7/build/dist' } });
 require( [ 'echarts', 'echarts/chart/bar' ],
  function (ec) {
   var myChart = ec.init(document.getElementById('<?php echo $div; ?>')); 
   var option = {
	   title : { text: 'Delito: <?php echo $delito; ?> Por Area', subtext: 'Conteo hasta <?php echo $meses[date($datos_atts['mes'])-1]; ?>' },
    tooltip : {
        trigger: 'axis'
    },
    toolbox: {
        show : false,
        feature : {
            dataView : {show: false, readOnly: false},
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    calculable : true,
    xAxis : [ { type : 'category', data : [<?php echo $categoria; ?>] } ],
    yAxis : [ { type : 'value' } ],
    series : [
        {
            name:'Area',
            type:'bar',
            data:[<?php echo $categoriaS; ?>]
        }
    ]
};
  myChart.setOption(option);
}                   
                    
 );
</script>
