<?php 

function dconvert($string){ //Funktion wandelt Datumstring um
	$substring1=substr($string,-2);
	$substring2=substr($string,2,2);
	$substring3=substr($string,0,2);
	return $substring1.".".$substring2.".20".$substring3;
}
?>
