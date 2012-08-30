<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="css/navbar.css" type="text/css" />
<link rel="stylesheet" href="css/general.css" type="text/css" />
<title>Auswahl</title>
</head>
<body>


<?php
session_start();
$datum = date('ymd', mktime(0, 0, 0, date("m")  , date("d"), date("Y")))*1;

// Auswahl Thema, Lektion, bereit zur Abfrage

if (isset ($_POST["topics"]) && !isset($_POST["Status1"]) && !isset($_POST["Status2"])&& !isset($_POST["Status3"])){
	$_SESSION["abfrage1"] = "SELECT * FROM kartei WHERE Abfrage <= ". $datum ." AND Thema LIKE '". $_POST['topics']."' AND Lektion LIKE '". $_POST['units']."' AND Status = 2 ";
	$_SESSION["abfrage2"] = "SELECT * FROM kartei WHERE Abfrage <= ". $datum ." AND Thema LIKE '". $_POST['topics']."' AND Lektion LIKE '". $_POST['units']."' AND Status = 2 ORDER BY id ASC LIMIT ";
	$_SESSION["Sprung"] = false;
	header ("HTTP/1.1 301 Moved Permanently"); 
	header ("Location: abfrage.php"); 
	}	
// Auswahl Thema, Lektion, inaktiv
else if (isset($_POST["Status1"]) && !isset($_POST["Status2"])&& !isset($_POST["Status3"])){
	
	$_SESSION["abfrage1"] = "SELECT * FROM kartei WHERE Thema LIKE '". $_POST['topics']."' AND Lektion LIKE '". $_POST['units']."' AND Status = '1'";
	$_SESSION["abfrage2"] = "SELECT * FROM kartei WHERE Thema LIKE '". $_POST['topics']."' AND Lektion LIKE '". $_POST['units']."' AND Status = '1' ORDER BY id ASC LIMIT ";
	$_SESSION["Sprung"] = false;
	header ("HTTP/1.1 301 Moved Permanently"); 
	header ("Location: abfrage.php"); 
	}	
// Auswahl Thema, Lektion, aktiv
else if (!isset($_POST["Status1"]) && isset($_POST["Status2"])&& !isset($_POST["Status3"])){
	
	$_SESSION["abfrage1"] = "SELECT * FROM kartei WHERE Thema LIKE '". $_POST['topics']."' AND Lektion LIKE '". $_POST['units']."' AND Status = '2'";
	$_SESSION["abfrage2"] = "SELECT * FROM kartei WHERE Thema LIKE '". $_POST['topics']."' AND Lektion LIKE '". $_POST['units']."' AND Status = '2' ORDER BY id ASC LIMIT ";
	$_SESSION["Sprung"] = false;
	header ("HTTP/1.1 301 Moved Permanently"); 
	header ("Location: abfrage.php"); 
	}	
// Auswahl Thema, Lektion, gelernt
else if (!isset($_POST["Status1"]) && !isset($_POST["Status2"])&& isset($_POST["Status3"])){
	
	$_SESSION["abfrage1"] = "SELECT * FROM kartei WHERE Thema LIKE '". $_POST['topics']."' AND Lektion LIKE '". $_POST['units']."' AND Status = '3'";
	$_SESSION["abfrage2"] = "SELECT * FROM kartei WHERE Thema LIKE '". $_POST['topics']."' AND Lektion LIKE '". $_POST['units']."' AND Status = '3' ORDER BY id ASC LIMIT ";
	$_SESSION["Sprung"] = false;
	header ("HTTP/1.1 301 Moved Permanently"); 
	header ("Location: abfrage.php"); 
	}
// Auswahl Thema, Lektion, inaktiv, aktiv	
else if (isset($_POST["Status1"]) && isset($_POST["Status2"])&& !isset($_POST["Status3"])){
	
	$_SESSION["abfrage1"] = "SELECT * FROM kartei WHERE Thema LIKE '". $_POST['topics']."' AND Lektion LIKE '". $_POST['units']."' AND (Status = '1' OR Status = '2') ";
	$_SESSION["abfrage2"] = "SELECT * FROM kartei WHERE Thema LIKE '". $_POST['topics']."' AND Lektion LIKE '". $_POST['units']."' AND (Status = '1' OR Status = '2') ORDER BY id ASC LIMIT ";
	$_SESSION["Sprung"] = false;
	header ("HTTP/1.1 301 Moved Permanently"); 
	header ("Location: abfrage.php"); 
	}	
	
// Auswahl Thema, Lektion, inaktiv, gelernt	
else if (isset($_POST["Status1"]) && isset($_POST["Status2"])&& !isset($_POST["Status3"])){
	
	$_SESSION["abfrage1"] = "SELECT * FROM kartei WHERE Thema LIKE '". $_POST['topics']."' AND Lektion LIKE '". $_POST['units']."' AND (Status = '1' OR Status = '3') ";
	$_SESSION["abfrage2"] = "SELECT * FROM kartei WHERE Thema LIKE '". $_POST['topics']."' AND Lektion LIKE '". $_POST['units']."' AND (Status = '1' OR Status = '3') ORDER BY id ASC LIMIT ";
	$_SESSION["Sprung"] = false;
	header ("HTTP/1.1 301 Moved Permanently"); 
	header ("Location: abfrage.php"); 
	}		

// Auswahl Thema, Lektion, aktiv, gelernt	
else if (isset($_POST["Status1"]) && isset($_POST["Status2"])&& !isset($_POST["Status3"])){
	
	$_SESSION["abfrage1"] = "SELECT * FROM kartei WHERE Thema LIKE '". $_POST['topics']."' AND Lektion LIKE '". $_POST['units']."' AND (Status = '2' OR Status = '3') ";
	$_SESSION["abfrage2"] = "SELECT * FROM kartei WHERE Thema LIKE '". $_POST['topics']."' AND Lektion LIKE '". $_POST['units']."' AND (Status = '2' OR Status = '3') ORDER BY id ASC LIMIT ";
	$_SESSION["Sprung"] = false;
	header ("HTTP/1.1 301 Moved Permanently"); 
	header ("Location: abfrage.php"); 
	}		

// Auswahl Thema, Lektion, aktiv, inaktiv, gelernt	
else if ((isset($_POST["Status1"])) && (isset($_POST["Status2"])) && (isset($_POST["Status3"]))){
	$_SESSION["abfrage1"] = "SELECT * FROM kartei WHERE Thema LIKE '". $_POST['topics']."' AND Lektion LIKE '". $_POST['units']."' AND (Status = '1' OR Status = '2' OR Status = '3') ";
	$_SESSION["abfrage2"] = "SELECT * FROM kartei WHERE Thema LIKE '". $_POST['topics']."' AND Lektion LIKE '". $_POST['units']."' AND (Status = '1' OR Status = '2' OR Status = '3') ORDER BY id ASC LIMIT ";
	$_SESSION["Sprung"] = false;
	header ("HTTP/1.1 301 Moved Permanently"); 
	header ("Location: abfrage.php"); 
}





if(isset($_POST["Auswahl"])){ //Auswahl aller Themen
	if ($_POST["Auswahl"]== 1){
	$_SESSION["abfrage1"] = 'SELECT * FROM kartei';
	$_SESSION["abfrage2"]= 'SELECT * FROM kartei ORDER BY id ASC LIMIT ';
	$_SESSION["Sprung"] = false;
		header ("HTTP/1.1 301 Moved Permanently"); 
	header ("Location: abfrage.php"); 
	exit(); 
	}
	else if ($_POST["Auswahl"]== 2){ //Auswahl aller Themen die bereit zur Abfrage stehen
	$_SESSION["abfrage1"] = 'SELECT * FROM kartei WHERE Abfrage <= '. $datum .' AND Status = 2';
	$_SESSION["abfrage2"] = 'SELECT * FROM kartei WHERE Abfrage <= '. $datum .' AND Status = 2 ORDER BY id ASC LIMIT ';
	$_SESSION["Sprung"] = false;
	header ("HTTP/1.1 301 Moved Permanently"); 
	header ("Location: abfrage.php"); 
	}
}





include("navbar.php");
?>


<div id="auswahl">
<h1>Überschrift</h1>
<form action="auswahl.php" method="post">
<input type="radio" name="Auswahl" value=1> Alle Fragen anzeigen<br/>
<input type="radio" name="Auswahl" value=2> Abfrage aller ansehenden Fragen starten<br/>

<input type="submit" name="Text1" value="Anzeigen">
</form>



<form action="auswahl.php" method="post">
<p>Fragen eines Themas auswählen</p>



<?php
include"zugriff.inc.php";
$sql = "SELECT * FROM topics ORDER BY Thema ASC"; //Auswahl Thema
$resultt = mysqli_query($db, $sql); //Abfrage Thema

echo "<select name='topics'>"; 

while ($row = mysqli_fetch_assoc($resultt)){
		echo "<option value='". $row['id'] ."'>". $row['Thema'] ."</option>";
		
}//Ende der while-Schleife
echo "</select>";

$sql = "SELECT * FROM units ORDER BY Lektion ASC"; //Auswahl Thema
$resultt = mysqli_query($db, $sql); //Abfrage Thema

echo "<select name='units'>"; 

while ($row = mysqli_fetch_assoc($resultt)){
		echo "<option value='". $row['id'] ."'>". $row['Lektion'] ."</option>";
		
}//Ende der while-Schleife
echo "</select>";



  
echo "<p>    <input type='checkbox' name='Status1' value='1'> inaktiv<br>".
    "<input type='checkbox' name='Status2' value='2'> aktiv<br>".
    "<input type='checkbox' name='Status3' value='3'> gelernt  </p>";

?>
  
  

<input type="submit" name="Text2" value="Anzeigen">

</form>
</div>
</body>
</html>

