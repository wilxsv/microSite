<?php
header("Content-Type: application/json;charset=utf-8");
$contenido = "";
$temp = 0;

$max = $_GET["max"];
if ($max < 0 || $max > 100000 || $max == null )
	$max = 5000;

for($i=0 ; $i<$max ; $i++){
	if ($i){
		$contenido.=",";
		$temp = 1;
	}
	$contenido.='{"dump": 1,"registro": "'.date("Y-m-d H:i:s").'", "fecha": "'.getRandDate('2015-01-01','2016-12-31').'","delito": '.rand(1, 13).',"departamento": '.rand(1, 12).',"municipio": '.rand(1, 213).',"area": '.rand(1, 2).',"edad": '.rand(10, 70).',"sexo": '.rand(1, 3).',"vapp": '.rand(0, 1).',"arma": '.rand(1, 4).',"voip": '.rand(0, 1).',"movil": "ND","vrelacion": "ND"}';
}
echo "[$contenido]";

function getRandDate($start, $end){
	$datestart = strtotime($start);
	$dateend = strtotime($end);
	$daystep = 86400;
	$datebetween = abs(($dateend - $datestart) / $daystep);
	$randomday = rand(0, $datebetween);
	
	return date("Y-m-d", $datestart + ($randomday * $daystep));
}
?>
