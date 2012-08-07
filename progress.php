<?php
//Skript zur Berechnung des Lernfortschritts//PHP Auswertungsskript:



$newDate1 = date('ymd', mktime(0, 0, 0, date("m")  , date("d")+3, date("Y")));
$newDate2 = date('ymd', mktime(0, 0, 0, date("m")  , date("d")+7, date("Y")));
$newDate3 = date('ymd', mktime(0, 0, 0, date("m")  , date("d")+14, date("Y")));
$newDate4 = date('ymd', mktime(0, 0, 0, date("m")  , date("d")+21, date("Y")));
$newDate5 = date('ymd', mktime(0, 0, 0, date("m")  , date("d")+40, date("Y")));


if(isset($_POST["Ergebnis"]))	{ 
	include("zugriff.inc.php");
	$sqlab1="SELECT * FROM kartei WHERE id = ".$_POST["Zeile"];
	$result1 = mysqli_query($db, $sqlab1);
	$dsatz = mysqli_fetch_assoc($result1);

// if ja	
// Gedächtnisstufe 1

// ja LS 1 GD 1,2 SG 1,2,3,4 -> LS 2
	if($_POST["Ergebnis"] == "ja" && $dsatz["Lernstufe"] == 1 && ($dsatz["Gedaechtnisstufe"] == 1 || $dsatz["Gedaechtnisstufe"] == 2 )) {
		$sqlab2 = "UPDATE kartei SET Lernstufe = 2 WHERE id = ".$_POST["Zeile"]; 
		mysqli_query($db, $sqlab2);
		$_SESSION["Sprung"] = false;
		}
//ja LS 2 GD 1 SG 1,2,3,4 -> LS 3	
	else if($_POST["Ergebnis"] == "ja" && $dsatz["Lernstufe"] == 2 && $dsatz["Gedaechtnisstufe"] == 1 ){
		$sqlab2 = "UPDATE kartei SET Lernstufe = 3  WHERE id = ".$_POST["Zeile"]; 
		mysqli_query($db, $sqlab2);
		$_SESSION["Sprung"] = false;
		}
// ja LS 3,  GD 1, SG 2,3,4 -> LS 4 GD 1
	else if($_POST["Ergebnis"] == "ja" && $dsatz["Lernstufe"] == 3 && $dsatz["Gedaechtnisstufe"] == 1 && $dsatz["Schwierigkeitsgrad"] != 1 ) {
		$sqlab2 = "UPDATE kartei SET Lernstufe = 4 WHERE id = ".$_POST["Zeile"]; 
		mysqli_query($db, $sqlab2);
		$_SESSION["Sprung"] = false;
		}
// ja LS 4,  GD 1, SG 3,4 -> LS 5 GD 1
	else if($_POST["Ergebnis"] == "ja" && $dsatz["Lernstufe"] == 4 && $dsatz["Gedaechtnisstufe"] == 1 && ($dsatz["Schwierigkeitsgrad"] == 3 || $dsatz["Schwierigkeitsgrad"] == 4 )) {
		$sqlab2 = "UPDATE kartei SET Lernstufe = 5 WHERE id = ".$_POST["Zeile"]; 
		mysqli_query($db, $sqlab2);
		$_SESSION["Sprung"] = false;
		}
// ja LS 5,  GD 1, SG 4 -> LS 6 GD 1
	else if($_POST["Ergebnis"] == "ja" && $dsatz["Lernstufe"] == 5 && $dsatz["Gedaechtnisstufe"] == 1 && $dsatz["Schwierigkeitsgrad"] == 4 ) {
		$sqlab2 = "UPDATE kartei SET Lernstufe = 6 WHERE id = ".$_POST["Zeile"]; 
		mysqli_query($db, $sqlab2);
		$_SESSION["Sprung"] = false;
		}		
//-- GS-Sprünge:		
// ja LS 3,  GD 1, SG 1 -> LS 1 GD 2 nd 1
	else if($_POST["Ergebnis"] == "ja" && $dsatz["Lernstufe"] == 3 && $dsatz["Gedaechtnisstufe"] == 1 && $dsatz["Schwierigkeitsgrad"] == 1 ) {
		$sqlab2 = "UPDATE kartei SET Lernstufe = 1, Gedaechtnisstufe = 2, Abfrage = ". $newDate1*1 ." WHERE id = ".$_POST["Zeile"]; 
		mysqli_query($db, $sqlab2);
		$_SESSION["Sprung"] = true;
		}
// ja LS 4,  GD 1, SG 2 -> LS 1 GD 2 nd1
	else if($_POST["Ergebnis"] == "ja" && $dsatz["Lernstufe"] == 4 && $dsatz["Gedaechtnisstufe"] == 1 && $dsatz["Schwierigkeitsgrad"] == 2 ) {
		$sqlab2 = "UPDATE kartei SET Lernstufe = 1, Gedaechtnisstufe = 2, Abfrage = ". $newDate1*1 ." WHERE id = ".$_POST["Zeile"]; 
		mysqli_query($db, $sqlab2);
		$_SESSION["Sprung"] = true;
		}
// ja LS 5,  GD 1, SG 3 -> LS 1 GD 2 nd1
	else if($_POST["Ergebnis"] == "ja" && $dsatz["Lernstufe"] == 5 && $dsatz["Gedaechtnisstufe"] == 1 && $dsatz["Schwierigkeitsgrad"] == 3 ) {
		$sqlab2 = "UPDATE kartei SET Lernstufe = 1, Gedaechtnisstufe = 2, Abfrage = ". $newDate1*1 ." WHERE id = ".$_POST["Zeile"]; 
		mysqli_query($db, $sqlab2);
		$_SESSION["Sprung"] = true;
		} 
// ja LS 6,  GD 1, SG 4 -> LS 1 GD 2 nd1
	else if($_POST["Ergebnis"] == "ja" && $dsatz["Lernstufe"] == 6 && $dsatz["Gedaechtnisstufe"] == 1 && $dsatz["Schwierigkeitsgrad"] == 4 ) {
		$sqlab2 = "UPDATE kartei SET Lernstufe = 1, Gedaechtnisstufe = 2, Abfrage = ". $newDate1*1 ." WHERE id = ".$_POST["Zeile"]; 
		mysqli_query($db, $sqlab2);
		$_SESSION["Sprung"] = true;
		}

// Gedächtnisstufe 2
		
// ja LS 2,  GD 2, SG 2, 3, 4 -> LS 3
	else if($_POST["Ergebnis"] == "ja" && $dsatz["Lernstufe"] == 2 && $dsatz["Gedaechtnisstufe"] == 2 && $dsatz["Schwierigkeitsgrad"] != 1 ) {
		$sqlab2 = "UPDATE kartei SET Lernstufe = 3 WHERE id = ".$_POST["Zeile"]; 
		mysqli_query($db, $sqlab2);
		}
// ja LS 3,  GD 2, SG 3,4 -> LS 4
	else if($_POST["Ergebnis"] == "ja" && $dsatz["Lernstufe"] == 3 && $dsatz["Gedaechtnisstufe"] == 2 && ($dsatz["Schwierigkeitsgrad"] == 3 || $dsatz["Schwierigkeitsgrad"] == 4 )) {
		$sqlab2 = "UPDATE kartei SET Lernstufe = 4 WHERE id = ".$_POST["Zeile"]; 
		mysqli_query($db, $sqlab2);
		}
// ja LS 4,  GD 2, SG 4 -> LS 5
	else if($_POST["Ergebnis"] == "ja" && $dsatz["Lernstufe"] == 4 && $dsatz["Gedaechtnisstufe"] == 2 && $dsatz["Schwierigkeitsgrad"] == 4 ) {
		$sqlab2 = "UPDATE kartei SET Lernstufe = 5 WHERE id = ".$_POST["Zeile"]; 
		mysqli_query($db, $sqlab2);
		}	

//-- GS-Sprünge:		
// ja LS 2,  GD 2, SG 1 -> LS 1 GD 3 nd 2
	else if($_POST["Ergebnis"] == "ja" && $dsatz["Lernstufe"] == 2 && $dsatz["Gedaechtnisstufe"] == 2 && $dsatz["Schwierigkeitsgrad"] == 1 ) {
		$sqlab2 = "UPDATE kartei SET Lernstufe = 1, Gedaechtnisstufe = 3, Abfrage = ". $newDate2*1 ." WHERE id = ".$_POST["Zeile"]; 
		mysqli_query($db, $sqlab2);
		}
// ja LS 3,  GD 2, SG 2 -> LS 1 GD 3 nd1
	else if($_POST["Ergebnis"] == "ja" && $dsatz["Lernstufe"] == 3 && $dsatz["Gedaechtnisstufe"] == 2 && $dsatz["Schwierigkeitsgrad"] == 2 ) {
		$sqlab2 = "UPDATE kartei SET Lernstufe = 1, Gedaechtnisstufe = 3, Abfrage = ". $newDate2*1 ." WHERE id = ".$_POST["Zeile"]; 
		mysqli_query($db, $sqlab2);
		}
// ja LS 4,  GD 2, SG 3 -> LS 1 GD 3 nd1
	else if($_POST["Ergebnis"] == "ja" && $dsatz["Lernstufe"] == 4 && $dsatz["Gedaechtnisstufe"] == 2 && $dsatz["Schwierigkeitsgrad"] == 3 ) {
		$sqlab2 = "UPDATE kartei SET Lernstufe = 1, Gedaechtnisstufe = 3, Abfrage = ". $newDate2*1 ." WHERE id = ".$_POST["Zeile"]; 
		mysqli_query($db, $sqlab2);
		} 
// ja LS 5,  GD 2, SG 4 -> LS 1 GD 3 nd1
	else if($_POST["Ergebnis"] == "ja" && $dsatz["Lernstufe"] == 5 && $dsatz["Gedaechtnisstufe"] == 2 && $dsatz["Schwierigkeitsgrad"] == 4 ) {
		$sqlab2 = "UPDATE kartei SET Lernstufe = 1, Gedaechtnisstufe = 3, Abfrage = ". $newDate2*1 ." WHERE id = ".$_POST["Zeile"]; 
		mysqli_query($db, $sqlab2);	
		}
// Gedächtnisstufe 3

// ja LS 1,  GD 3, SG 2,3,4 -> LS 2
	else if($_POST["Ergebnis"] == "ja" && $dsatz["Lernstufe"] == 1 && $dsatz["Gedaechtnisstufe"] == 3 && $dsatz["Schwierigkeitsgrad"] != 1 ) {
		$sqlab2 = "UPDATE kartei SET Lernstufe = 2 WHERE id = ".$_POST["Zeile"]; 
		mysqli_query($db, $sqlab2);
		}
// ja LS 2,  GD 3, SG 3,4 -> LS 3
	else if($_POST["Ergebnis"] == "ja" && $dsatz["Lernstufe"] == 2 && $dsatz["Gedaechtnisstufe"] == 3 && ($dsatz["Schwierigkeitsgrad"] == 3 || $dsatz["Schwierigkeitsgrad"] == 4 )) {
		$sqlab2 = "UPDATE kartei SET Lernstufe = 3 WHERE id = ".$_POST["Zeile"]; 
		mysqli_query($db, $sqlab2);
		}
// ja LS 3,  GD 3, SG 4 -> LS 4
	else if($_POST["Ergebnis"] == "ja" && $dsatz["Lernstufe"] == 3 && $dsatz["Gedaechtnisstufe"] == 3 && $dsatz["Schwierigkeitsgrad"] == 4 ) {
		$sqlab2 = "UPDATE kartei SET Lernstufe = 4 WHERE id = ".$_POST["Zeile"]; 
		mysqli_query($db, $sqlab2);
		}
//-- GS-Sprünge:		
// ja LS 1,  GD 3, SG 1 -> LS 1 GD 4 nd 3
	else if($_POST["Ergebnis"] == "ja" && $dsatz["Lernstufe"] == 1 && $dsatz["Gedaechtnisstufe"] == 3 && $dsatz["Schwierigkeitsgrad"] == 1 ) {
		$sqlab2 = "UPDATE kartei SET Lernstufe = 1, Gedaechtnisstufe = 4, Abfrage = ". $newDate3*1 ." WHERE id = ".$_POST["Zeile"]; 
		mysqli_query($db, $sqlab2);
		}
// ja LS 2,  GD 3, SG 2 -> LS 1 GD 4 nd3
	else if($_POST["Ergebnis"] == "ja" && $dsatz["Lernstufe"] == 2 && $dsatz["Gedaechtnisstufe"] == 3 && $dsatz["Schwierigkeitsgrad"] == 2 ) {
		$sqlab2 = "UPDATE kartei SET Lernstufe = 1, Gedaechtnisstufe = 4, Abfrage = ". $newDate3*1 ." WHERE id = ".$_POST["Zeile"]; 
		mysqli_query($db, $sqlab2);
		}
// ja LS 3,  GD 3, SG 3 -> LS 1 GD 4 nd3
	else if($_POST["Ergebnis"] == "ja" && $dsatz["Lernstufe"] == 3 && $dsatz["Gedaechtnisstufe"] == 3 && $dsatz["Schwierigkeitsgrad"] == 3 ) {
		$sqlab2 = "UPDATE kartei SET Lernstufe = 1, Gedaechtnisstufe = 4, Abfrage = ". $newDate3*1 ." WHERE id = ".$_POST["Zeile"]; 
		mysqli_query($db, $sqlab2);
		} 
// ja LS 4,  GD 3, SG 4 -> LS 1 GD 4 nd3
	else if($_POST["Ergebnis"] == "ja" && $dsatz["Lernstufe"] == 4 && $dsatz["Gedaechtnisstufe"] == 3 && $dsatz["Schwierigkeitsgrad"] == 4 ) {
		$sqlab2 = "UPDATE kartei SET Lernstufe = 1, Gedaechtnisstufe = 4, Abfrage = ". $newDate3*1 ." WHERE id = ".$_POST["Zeile"]; 
		mysqli_query($db, $sqlab2);			
		}
	
// Gedächtnisstufe 4

// ja LS 1,  GD 4, SG 3,4 -> LS 2
	else if($_POST["Ergebnis"] == "ja" && $dsatz["Lernstufe"] == 1 && $dsatz["Gedaechtnisstufe"] == 4 && ($dsatz["Schwierigkeitsgrad"] == 3 || $dsatz["Schwierigkeitsgrad"] == 4 )) {
		$sqlab2 = "UPDATE kartei SET Lernstufe = 2 WHERE id = ".$_POST["Zeile"]; 
		mysqli_query($db, $sqlab2);
		}
// ja LS 2,  GD 4, SG 4 -> LS 3 
	else if($_POST["Ergebnis"] == "ja" && $dsatz["Lernstufe"] == 2 && $dsatz["Gedaechtnisstufe"] == 4 && $dsatz["Schwierigkeitsgrad"] == 4 ) {
		$sqlab2 = "UPDATE kartei SET Lernstufe = 3 WHERE id = ".$_POST["Zeile"]; 
		mysqli_query($db, $sqlab2);
		}
//-- GS-Sprünge:		
// ja LS 1,  GD 4, SG 1, 2 -> LS 1 GD 5 nd4 //hier muss umspringen
	else if($_POST["Ergebnis"] == "ja" && $dsatz["Lernstufe"] == 1 && $dsatz["Gedaechtnisstufe"] == 4 && ($dsatz["Schwierigkeitsgrad"] == 1 || $dsatz["Schwierigkeitsgrad"] == 2 ) ){
		$sqlab2 = "UPDATE kartei SET Gedaechtnisstufe = 5, Abfrage = ". $newDate4*1 ." WHERE id = ".$_POST["Zeile"]; 
		mysqli_query($db, $sqlab2);
		}
// ja LS 2,  GD 4, SG 3 -> LS 1 GD 5 nd4
	else if($_POST["Ergebnis"] == "ja" && $dsatz["Lernstufe"] == 2 && $dsatz["Gedaechtnisstufe"] == 4 && $dsatz["Schwierigkeitsgrad"] == 3 ) {
		$sqlab2 = "UPDATE kartei SET Lernstufe = 1, Gedaechtnisstufe = 5, Abfrage = ". $newDate4*1 ." WHERE id = ".$_POST["Zeile"]; 
		mysqli_query($db, $sqlab2);
		}
// ja LS 3,  GD 4, SG 4 -> LS 1 GD 5 nd4
	else if($_POST["Ergebnis"] == "ja" && $dsatz["Lernstufe"] == 3 && $dsatz["Gedaechtnisstufe"] == 4 && $dsatz["Schwierigkeitsgrad"] == 4 ) {
		$sqlab2 = "UPDATE kartei SET Lernstufe = 1, Gedaechtnisstufe = 5, Abfrage = ". $newDate4*1 ." WHERE id = ".$_POST["Zeile"]; 
		mysqli_query($db, $sqlab2);
		} 

// Gedächtnisstufe 5

// ja LS 1,  GD 5, SG 4 -> LS 2
	else if($_POST["Ergebnis"] == "ja" && $dsatz["Lernstufe"] == 1 && $dsatz["Gedaechtnisstufe"] == 5 && $dsatz["Schwierigkeitsgrad"] == 4 ) {
		$sqlab2 = "UPDATE kartei SET Lernstufe = 2 WHERE id = ".$_POST["Zeile"]; 
		mysqli_query($db, $sqlab2);
		}

//-- GS-Sprünge:		
// ja LS 1,  GD 5, SG 1, 2, 3 -> LS 1 GD 6 nd5
	else if($_POST["Ergebnis"] == "ja" && $dsatz["Lernstufe"] == 1 && $dsatz["Gedaechtnisstufe"] == 5 && $dsatz["Schwierigkeitsgrad"] != 4 ){
		$sqlab2 = "UPDATE kartei SET Lernstufe = 1, Gedaechtnisstufe = 6, Abfrage = ". $newDate5*1 ." WHERE id = ".$_POST["Zeile"]; 
		mysqli_query($db, $sqlab2);
		}
// ja LS 2,  GD 5, SG 4 -> LS 1 GD 6 nd5
	else if($_POST["Ergebnis"] == "ja" && $dsatz["Lernstufe"] == 2 && $dsatz["Gedaechtnisstufe"] == 5 && $dsatz["Schwierigkeitsgrad"] == 4 ) {
		$sqlab2 = "UPDATE kartei SET Lernstufe = 1, Gedaechtnisstufe = 6, Abfrage = ". $newDate5*1 ." WHERE id = ".$_POST["Zeile"]; 
		mysqli_query($db, $sqlab2);
		}

// Gedächtnisstufe 6		
// ja LS 1,  GD 6, SG 1, 2, 3, 4 -> GD 7
	else if($_POST["Ergebnis"] == "ja" && $dsatz["Lernstufe"] == 1 && $dsatz["Gedaechtnisstufe"] == 6){
		$sqlab2 = "UPDATE kartei SET Gedaechtnisstufe = 7 WHERE id = ".$_POST["Zeile"]; 
		mysqli_query($db, $sqlab2);
		}

// if nein:
//Gedächtnisstufe 1

		else if($_POST["Ergebnis"] == "nein" && $dsatz["Lernstufe"] > 1 && $dsatz["Gedaechtnisstufe"] == 1){
		$sqlab2 = "UPDATE kartei SET Lernstufe = 1 WHERE id = ".$_POST["Zeile"]; 
		mysqli_query($db, $sqlab2);
		}

//Gedächtnisstufe 2

		else if($_POST["Ergebnis"] == "nein" && $dsatz["Lernstufe"] == 1 && $dsatz["Gedaechtnisstufe"] == 2){
		$sqlab2 = "UPDATE kartei SET Gedaechtnisstufe = 1 WHERE id = ".$_POST["Zeile"]; 
		mysqli_query($db, $sqlab2);
		}

		else if($_POST["Ergebnis"] == "nein" && $dsatz["Lernstufe"] > 1 && $dsatz["Gedaechtnisstufe"] == 2){
		$sqlab2 = "UPDATE kartei SET Lernstufe = 1 WHERE id = ".$_POST["Zeile"]; 
		mysqli_query($db, $sqlab2);
		}
//Gedächtnisstufe 3

		else if($_POST["Ergebnis"] == "nein" && $dsatz["Lernstufe"] == 1 && $dsatz["Gedaechtnisstufe"] == 3){
		$sqlab2 = "UPDATE kartei SET Gedaechtnisstufe = 2 WHERE id = ".$_POST["Zeile"]; 
		mysqli_query($db, $sqlab2);
		}

		else if($_POST["Ergebnis"] == "nein" && $dsatz["Lernstufe"] > 1 && $dsatz["Gedaechtnisstufe"] == 3){
		$sqlab2 = "UPDATE kartei SET Lernstufe = 1 WHERE id = ".$_POST["Zeile"]; 
		mysqli_query($db, $sqlab2);
		}

//Gedächtnisstufe 4

		else if($_POST["Ergebnis"] == "nein" && $dsatz["Lernstufe"] == 1 && $dsatz["Gedaechtnisstufe"] == 4){
		$sqlab2 = "UPDATE kartei SET Gedaechtnisstufe = 3 WHERE id = ".$_POST["Zeile"]; 
		mysqli_query($db, $sqlab2);
		}

		else if($_POST["Ergebnis"] == "nein" && $dsatz["Lernstufe"] > 1 && $dsatz["Gedaechtnisstufe"] == 4){
		$sqlab2 = "UPDATE kartei SET Lernstufe = 1 WHERE id = ".$_POST["Zeile"]; 
		mysqli_query($db, $sqlab2);
		}			
	
//Gedächtnisstufe 5

		else if($_POST["Ergebnis"] == "nein" && $dsatz["Lernstufe"] == 1 && $dsatz["Gedaechtnisstufe"] == 5){
		$sqlab2 = "UPDATE kartei SET Gedaechtnisstufe = 4 WHERE id = ".$_POST["Zeile"]; 
		mysqli_query($db, $sqlab2);
		}

		else if($_POST["Ergebnis"] == "nein" && $dsatz["Lernstufe"] > 1 && $dsatz["Gedaechtnisstufe"] == 5){
		$sqlab2 = "UPDATE kartei SET Lernstufe = 1 WHERE id = ".$_POST["Zeile"]; 
		mysqli_query($db, $sqlab2);
		}
//Gedächtnisstufe 6

		else if($_POST["Ergebnis"] == "nein" && $dsatz["Lernstufe"] == 1 && $dsatz["Gedaechtnisstufe"] == 6){
		$sqlab2 = "UPDATE kartei SET Gedaechtnisstufe = 5 WHERE id = ".$_POST["Zeile"]; 
		mysqli_query($db, $sqlab2);
		}

		else if($_POST["Ergebnis"] == "nein" && $dsatz["Lernstufe"] > 1 && $dsatz["Gedaechtnisstufe"] == 6){
		$sqlab2 = "UPDATE kartei SET Lernstufe = 1 WHERE id = ".$_POST["Zeile"]; 
		mysqli_query($db, $sqlab2);
		}
	
	} //Ende der if - isset Bedingung





?>