<!DOCTYPE html>


<?php
$datum = date('ymd', mktime(0, 0, 0, date("m")  , date("d"), date("Y")))*1;
session_start();
if(isset($_POST["Auswahl"])){
	if ($_POST["Auswahl"]== 1){
	$_SESSION["abfrage1"] = 'SELECT * FROM kartei';
	$_SESSION["abfrage2"]= 'SELECT * FROM kartei ORDER BY id ASC LIMIT ';
	$_SESSION["Sprung"] = false;
		header ("HTTP/1.1 301 Moved Permanently"); 
	header ("Location: abfrage.php"); 
	exit(); 
	}
	else if ($_POST["Auswahl"]== 2){
	$_SESSION["abfrage1"] = 'SELECT * FROM kartei WHERE Abfrage <= '. $datum .'';
	$_SESSION["abfrage2"] = 'SELECT * FROM kartei WHERE Abfrage <= '. $datum .' ORDER BY id ASC LIMIT ';
	$_SESSION["Sprung"] = false;
	header ("HTTP/1.1 301 Moved Permanently"); 
	header ("Location: abfrage.php"); 
	}
	else if ($_POST["Auswahl"]== 3){
	//$_SESSION["abfrage1"] = "SELECT * FROM kartei WHERE Thema LIKE '". $_POST['Thema']."' ";
	//$_SESSION["abfrage2"] = "SELECT * FROM kartei WHERE Thema LIKE '". $_POST['Thema']."' ORDER BY id ASC LIMIT ";
	
	
	$_SESSION["abfrage1"] = "SELECT * FROM kartei WHERE Abfrage <= ". $datum ." AND Thema LIKE '". $_POST['Thema']."' ";
	$_SESSION["abfrage2"] = "SELECT * FROM kartei WHERE Abfrage <= ". $datum ." AND Thema LIKE '". $_POST['Thema']."' ORDER BY id ASC LIMIT ";
	header ("HTTP/1.1 301 Moved Permanently"); 
	header ("Location: abfrage.php"); 
	}
	
	// echo '<script language="javascript">window.location="'.$url.'";</script>';  
	}







?>
<form action="auswahl.php" method="post">
<input type="radio" name="Auswahl" value=1> Alles anzeigen<br/>
<input type="radio" name="Auswahl" value=2> Abfrage starten<br/>
<input type="radio" name="Auswahl" value=3> PHP Fragen starten<br/>
<p>Thema auswählen</p>
  <p>
    <select name="Thema"> 
      <option value="PHP">PHP</option>
      <option value="Biologie">Biologie</option>
      <option value="Mathematik">Mathematik</option>
      <option value="JavaScript">JavaScript</option>
      <option value="MySQL">MySQL</option>
      <option value="Allgemeinwissen">Allgemeinwissen</option>

    </select>
  </p>
<input type="submit" name="TEST" value="Anzeigen">

</form>


