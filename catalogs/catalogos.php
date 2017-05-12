<?php include('cabecera.php');

$tab="institucion";
if(isset($_POST["tab"])){
    $tab=$_POST["tab"];
}
echo "
<style type='text/css'>
    .modal-dialog {
        position: inherit;
    }
</style>
</br>
  <ul class='nav nav-tabs' role='tablist' id='myTabs'>
    <li role='presentation'>
    	<a href='#institucion' aria-controls='institucion' role='tab' data-toggle='tab'>
    	<span class='glyphicon glyphicon-home' aria-hidden='true'></span>Instituciones</a>
    </li>
    <li role='presentation'>
    	<a href='#area' aria-controls='area' role='tab' data-toggle='tab'>
        <span class='glyphicon glyphicon-th-large' aria-hidden='true'></span>Areas</a>
    </li>
    <li role='presentation'>
    	<a href='#componente' aria-controls='componente' role='tab' data-toggle='tab'>
        <span class='glyphicon glyphicon-tent' aria-hidden='true'></span>Componentes</a>
    </li>
    <li role='presentation'>
       	<a href='#tipo' aria-controls='tipo' role='tab' data-toggle='tab'>
        <span class='glyphicon glyphicon-list-alt' aria-hidden='true'></span>Tipo de Herramienta</a>
    </li>
    <li role='presentation'>

    	<a href='#clase' aria-controls='clase' role='tab' data-toggle='tab'>
        <span class='glyphicon glyphicon-wrench' aria-hidden='true'></span>Clase de Herramienta</a>
    </li>
    <li role='presentation'>
    	<a href='#ambito' aria-controls='ambito' role='tab' data-toggle='tab'>
        <span class='glyphicon glyphicon-th-list' aria-hidden='true'></span>Ámbitos de aplicación</a>
    </li>
    <li role='presentation'>
        <a href='#validacion' aria-controls='validacion' role='tab' data-toggle='tab'>
        <span class='glyphicon glyphicon-check' aria-hidden='true'></span>Criterios de Validacion</a>
    </li>
    <li role='presentation'>
        <a href='#grupo' aria-controls='grupo' role='tab' data-toggle='tab'>
        <span class='glyphicon glyphicon-sunglasses' aria-hidden='true'></span>Grupos Vulnerables</a>
    </li>
    <li role='presentation'>
        <a href='#incluye' aria-controls='incluye' role='tab' data-toggle='tab'>
        <span class='glyphicon glyphicon-screenshot' aria-hidden='true'></span>Campos de acción</a>
    </li>
    <li role='presentation'>
       <a href='#pregunta' aria-controls='pregunta' role='tab' data-toggle='tab'>
       <span class='glyphicon glyphicon-question-sign' aria-hidden='true'></span>Aplicabilidad ¿Cómo?</a>
    </li>
   <!-- <li role='presentation'>
        <a href='#contacto' aria-controls='contacto' role='tab' data-toggle='tab'>
        <span class='glyphicon glyphicon-user' aria-hidden='true'></span>Contactos</a>
    </li>-->
  </ul>
<div class='tab-content'>";
include('institucion.php');
include('area.php');
include('componente.php');  
include('tipo.php'); 
include('clase.php'); 
include('ambito.php'); 
include('validacion.php'); 
include('grupo.php'); 
include('incluye.php'); 
include('pregunta.php'); 
include('contacto.php'); 
?>
</div>