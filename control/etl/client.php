<?php
include('config/nusoap.php');
$client = new nusoap_client('http://127.0.0.1/ws/server.php?wsdl','wsdl');
$err = $client->getError();
if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}

$param = array('tcParametroA' => 'Enrique','tcParametroB' => 'Miranda');
$result = $client->call('MetodoPrueba', $param);

//$param = array('title' => 'oooooooooooooola');
//$result = $client->call('SetSaludo', $param);

if ($client->fault) {
	echo '<h2>Fault</h2><pre>';
	print_r($result);
	echo '</pre>';
} else {
	// Check for errors
	$err = $client->getError();
	if ($err) {
		// Display the error
		echo '<h2>Error</h2><pre>' . $err . '</pre>';
	} else {
		// Display the result
		echo '<h2>Result</h2><pre>';
		print($result);
		echo '</pre>';
	}
}

echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';
?>
