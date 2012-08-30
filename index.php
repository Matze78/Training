<!DOCTYPE html>
<html>
<head>
<title>Home</title>
<meta charset="utf-8">
<link rel="stylesheet" href="css/navbar.css" type="text/css" />
<link rel="stylesheet" href="css/general.css" type="text/css" />
</head>
<body>
<?php
include("navbar.php");
include("zugriff.inc.php");

$datum = date('ymd', mktime(0, 0, 0, date("m")  , date("d"), date("Y")))*1;


echo"<div id='wrapper'>";
$sql = "SELECT * FROM kartei; ";
$result = mysqli_query($db, $sql);
$zeilen = mysqli_num_rows($result);
echo "Anzahl der Fragen: ".$zeilen."<br />";

$sql="SELECT * FROM kartei WHERE Abfrage <= ". $datum ;
$result = mysqli_query($db, $sql);
$zeilen = mysqli_num_rows($result);
echo "Anzahl der offenen Fragen: ".$zeilen ."<br />";

$sql="SELECT * FROM kartei WHERE Status ='1'";
$result = mysqli_query($db, $sql);
$zeilen = mysqli_num_rows($result);
echo "Anzahl der inaktiven Fragen: ".$zeilen ."<br />";

$sql="SELECT * FROM kartei WHERE Status ='3'";
$result = mysqli_query($db, $sql);
$zeilen = mysqli_num_rows($result);
echo "Anzahl der gelernten Fragen: ".$zeilen ."<br />";


echo"</div>";//Ende wrapper
?>
</body>
</html>