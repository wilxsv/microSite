<?php
wp_enqueue_script('jquery-ui-datepicker');
wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');

echo "
        <link href='".plugin_dir_url( __FILE__ )."bootstrap-3.3.6/css/bootstrap.min.css' rel='stylesheet'> 
	    <meta name='viewport' content='width=device-width, initial-scale=1'>
	    <script src='".plugin_dir_url( __FILE__ )."bootstrap-3.3.6/js/jquery-1.11.3.min.js'></script>
	    <script src='".plugin_dir_url( __FILE__ )."bootstrap-3.3.6/js/bootstrap.min.js'></script>
	    
		
	    <link href='".plugin_dir_url( __FILE__ )."bootstrap-3.3.6/css/dataTables.bootstrap.min.css' rel='stylesheet'>
	    <script src='".plugin_dir_url( __FILE__ )."bootstrap-3.3.6/js/jquery.dataTables.min.js'></script>
	    <script src='".plugin_dir_url( __FILE__ )."bootstrap-3.3.6/js/dataTables.bootstrap.min.js'></script>
	    <script src='".plugin_dir_url( __FILE__ )."../js/leaflet.js'></script>
	     <script src='".plugin_dir_url( __FILE__ )."../js/leaflet-geoip.js'></script>
		
		
";

?>
<style type="text/css">
	.modal-dialog {
		position: inherit;

	}
</style>