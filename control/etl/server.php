<?php
include('config/nusoap.php');

$server = new soap_server();
$server->configureWSDL('WebService de ejemplo', 'urn:WServidor');

$server->register('MetodoPrueba',											// method name
    array('tcParametroA' => 'xsd:string','tcParametroB' => 'xsd:string'),	// input parameters
    array('return' => 'xsd:string'),										// output parameters
    'urn:WServidor',													// namespace
    'urn:WServidor#MetodoPrueba',									// soapaction
    'rpc',																	// style
    'encoded',																// use
    'Retorna el datos'														// documentation
);
$server->register('SetSaludo',											// method name
    array('title' => 'xsd:string'),	// input parameters
    array('return' => 'xsd:string'),										// output parameters
    'urn:WServidor',													// namespace
    'urn:WServidor#SetSaludo',									// soapaction
    'rpc',																	// style
    'encoded',																// use
    'Registra un saludo'														// documentation
);

function MetodoPrueba($tcParametroA,$tcParametroB) {
  $db = new SQLite3('development.sqlite3');
  $results = $db->query('SELECT title FROM saludos ORDER BY RANDOM() LIMIT 1');
  while ($row = $results->fetchArray()) {
    return $row['title']." $tcParametroA $tcParametroB";
 }
	//return "SERVIDOR=".$_SERVER['PHP_SELF']."\n"."Tu escribiste =".strtoupper($tcParametroA)." ".strtoupper($tcParametroB);
}

function SetSaludo($title) {
  $dbhandle = sqlite_open('development.sqlite3');
  $query = sqlite_exec($dbhandle, "INSERT INTO saludos (title) VALUES ('".$title."')", $error);
  if (!$query) {
    return "Registro no ingresado";
  } else {
    return "Yes";//sqlite_changes($dbhandle);
  }
}

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
?>
