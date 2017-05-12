<?php
 add_menu_page('Administracion del micrositio de estadisticas', 'Configuracion MicroSitio de Analisis', 'manage_options', 'pnctools', 'listadoHerramienta', 'dashicons-book-alt');
 add_submenu_page('bvirtual', 'Ficha de Biblioteca Virtual', 'Agregar Herramienta','manage_options', 'agregaHerramienta','FormHerramientas');
 add_submenu_page('bvirtual', 'Parámetros generales', 'Parámetros','manage_options', 'catalogo-herramienta','parametros');
?>
