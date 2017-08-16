<?php 
global $wpdb;

$status = false;
$total = 0;

if(isset($_POST['importSubmit'])){
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
	if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$csvMimes)){
		if(is_uploaded_file($_FILES['file']['tmp_name'])){
			$csvFile = fopen($_FILES['file']['tmp_name'], 'r');
            fgetcsv($csvFile);
			switch($_FILES['file']['name']){
				case 'accidentes.csv':
					while(($line = fgetcsv($csvFile)) !== FALSE){
						$sql = "INSERT INTO accidentes (cuenta, departamento, municipio, anyo, mes, mes_num, dia, dia_num, hora, rangohora, tipoaccidente, tipovehiculo, danyos, causa) VALUES ($line[0], '$line[1]', '$line[2]', $line[3], '$line[4]', $line[5], '$line[6]', $line[7], '$line[8]', '$line[9]', '$line[10]', '$line[11]', '$line[12]', '$line[13]')";
						$wpdb->query($sql);
						$total+=1;
					}
					$status = 'succ';
					break;
				case 'delitos.csv':
					while(($line = fgetcsv($csvFile)) !== FALSE){
						$sql = "INSERT INTO delitos (cuenta, departamento, municipio, anyo, mes, mes_num, dia, dia_num, hora, rangohora, arma, delito, area) VALUES ($line[0], '$line[1]', '$line[2]', $line[3], '$line[4]', $line[5], '$line[6]', $line[7], '$line[8]', '$line[9]', '$line[10]', '$line[11]', '$line[12]')";
						$wpdb->query($sql);
						$total+=1;
					}
					$status = 'succ';
					break;
				case 'delitossexuales.csv':
					while(($line = fgetcsv($csvFile)) !== FALSE){
						$sql = "INSERT INTO delitossexuales (cuenta, departamento, municipio, anyo, mes, mes_num, dia, dia_num, hora, rangohora, arma, delito, area, sexo, edad, rangoedad) VALUES ($line[0], '$line[1]', '$line[2]', $line[3], '$line[4]', $line[5], '$line[6]', $line[7], '$line[8]', '$line[9]', '$line[10]', '$line[11]', '$line[12]', '$line[13]', '$line[14]', '$line[15]')";
						$wpdb->query($sql);
					}
					$status = 'succ';
					break;
				case 'detenidos.csv':
					while(($line = fgetcsv($csvFile)) !== FALSE){
						$sql = "INSERT INTO detenidos (cuenta, departamento, municipio, anyo, mes, mes_num, hora, rangohora, grupo_delito, delito, estructuracriminal, tipodetencion, sexo, edad, grupoedad) VALUES ($line[0], '$line[1]', '$line[2]', $line[3], '$line[4]', $line[5], '$line[6]', '$line[7]', '$line[8]', '$line[9]', '$line[10]', '$line[11]', '$line[12]', '$line[13]', '$line[14]')";
						$wpdb->query($sql);
						$total+=1;
					}
					$status = 'succ';
					break;
				case 'victimas.csv':
					while(($line = fgetcsv($csvFile)) !== FALSE){
						$sql = "INSERT INTO victimas (cuenta, departamento, municipio, anyo, mes, mes_num, dia, dia_num, hora, rangohora, tipoarma, delito, area, sexo, edad, grupoedad, pertenecepandilla, pandilla) VALUES ($line[0], '$line[1]', '$line[2]', $line[3], '$line[4]', $line[5], '$line[6]', $line[7], '$line[8]', '$line[9]', '$line[10]', '$line[11]', '$line[12]', '$line[13]', '$line[14]', '$line[15]', '$line[16]', '$line[17]')";
						$wpdb->query($sql);
						$total+=1;
					}
					$status = 'succ';
					break;
				default:
					$status = 'err';
			}
			fclose($csvFile);
		}
		else
		{
			$status = 'err';
		}
	}
	else
	{
		$status = 'invalid_file';
	}
	    
	    
}

if(!empty($status)){
    switch($status){
        case 'succ':
            $statusMsgClass = 'alert-success';
            $statusMsg = 'Datos actualizados. '."[ $total ]";
            break;
        case 'err':
            $statusMsgClass = 'alert-danger';
            $statusMsg = 'Se encontraron problemas en el archivo.';
            break;
        case 'invalid_file':
            $statusMsgClass = 'alert-danger';
            $statusMsg = 'Formato no compatible.';
            break;
        default:
            $statusMsgClass = '';
            $statusMsg = '';
    }
}

?>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style type="text/css">
 .panel-heading a{float: right;}
 #importFrm{margin-bottom: 20px;display: none;}
 #importFrm input[type=file] {display: inline;}
</style>
<div class="container">
	<h1>Modulo de carga de datos a micro sitio.</h1>
</div>
<div class="container">
    <?php if(!empty($statusMsg)){
        echo '<div class="alert '.$statusMsgClass.'">'.$statusMsg.'</div>';
    } ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            Listado de ultimos delitos
            <a href="javascript:void(0);" onclick="$('#importFrm').slideToggle();">Importar datos</a>
        </div>
        <div class="panel-body">
            <form  method="post" enctype="multipart/form-data" id="importFrm">
                <input type="file" name="file" />
                <input type="submit" class="btn btn-primary" name="importSubmit" value="Importar archivo">
            </form>
            <table class="table table-bordered">
                <thead>
                    <tr>
                      <th>Catalogo</th>
                      <th>Departamento</th>
                      <th>Municipio</th>
                      <th>Delito</th>
                      <th>Mes</th>
                      <th>Sexo</th>
                      <th>Registro</th>
                    </tr>
                </thead>
                <tbody>
					<?php
					$sql = "SELECT * FROM delitos ORDER BY registro DESC LIMIT 3";
					$hechos = $wpdb->get_results( $sql);
					foreach ($hechos as $key => $object) { 
					echo "<tr><td>Delito</td><td>$object->departamento</td><td>$object->municipio</td><td>$object->delito</td><td>$object->mes</td><td>$object->sexo</td><td>$object->registro</td></tr>";
					}
					 ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
