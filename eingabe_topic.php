<!DOCTYPE html>

<html>
<head>
<link rel="stylesheet" href="css/navbar.css" type="text/css" />
<link rel="stylesheet" href="css/general.css" type="text/css" />
<title>Eingabe des Themas</title>
<meta charset="utf-8">
</head>

<body>
<?php
include("navbar.php");
?>
<div id="wrapper">
<p>Neues Thema:</p>
<form action="eingabe_topic.php" method="post">
<input type="text" name="Thema" maxlength="40" /><br />
<input type="submit" value="Speichern">
<?php
//Eingabe speichern
if(isset($_POST["Thema"])){
include("zugriff.inc.php");



$Thema = mysqli_real_escape_string($db, $_POST["Thema"]);


$sql = "INSERT INTO `trainer`.`topics`  VALUES('','$Thema')";
mysqli_query($db, $sql);
//Erfolgsanzeige
if(mysqli_affected_rows($db) > 0) {
echo"<h3>" . $Thema. " wurde gespeichert</h3>";
}
else {
echo"<h3>Eintrag nicht erfolgreich</h3>";
}
}

?>
</div> <!--Ende Wrapper-->
</body>


</html>