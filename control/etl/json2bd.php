<?php
    $host = "localhost";
    $username = "root";
    $password = "1800";
    $dbname = "oip";
    $jsonUrl = "http://127.0.0.1/ws/gjson.php";
    
    $conn = new mysqli($host, $username, $password, $dbname);   
    if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
    }
    $json = file_get_contents($jsonUrl);
    $data = json_decode($json, true);
    foreach ($data as $row) {
		$stmt = $conn->prepare("INSERT INTO pnc_hechos (dump_hecho, registro_hecho, fecha_hecho, delito_hecho, departamento_hecho, municipio_hecho, area_hecho, sexo_hecho, edad_hecho, arma_hecho, vapp_hecho, voip_hecho, movil_hecho, vrelacion_hecho)
							VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("issiiiiiiiiiss", $dump, $registro, $fecha, $delito, $departamento, $municipio, $area, $sexo, $edad, $arma, $vapp, $voip, $movil, $vrelacion);
        $dump = $row['dump'];
        $registro = $row['registro'];
        $fecha = $row['fecha'];
        $delito = $row['delito'];
        $departamento = $row['departamento'];
        $municipio = $row['municipio'];
        $area = $row['area'];
        $sexo = $row['sexo'];
        $edad = $row['edad'];
        $arma = $row['arma'];
        $vapp = $row['vapp'];
        $voip = $row['voip'];
        $movil = $row['movil'];
        $vrelacion = $row['vrelacion'];
        $stmt->execute();
    }
    $stmt->close();
    $conn->close();
?>
