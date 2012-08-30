<!DOCTYPE html>

<html>
<head>
<title>Eingabe der Lektion</title>
<meta charset="utf-8">
</head>
<p>Lektion eingeben:<p>
<body>
<form action="eingabe_unit.php" method="post">
<input type="text" name="Lektion" maxlength="40" /><br />
<input type="submit" value="Speichern">
<?php
//Eingabe speichern
if(isset($_POST["Lektion"])){
include("zugriff.inc.php");



$Lektion = mysqli_real_escape_string($db, $_POST["Lektion"]);


$sql = "INSERT INTO `trainer`.`units`  VALUES('','$Lektion')";
mysqli_query($db, $sql);
//Erfolgsanzeige
if(mysqli_affected_rows($db) > 0) {
echo"<h3>" . $Lektion. " wurde gespeichert</h3>";
}
else {
echo"<h3>Eintrag nicht erfolgreich</h3>";
}
}

?>

</body>


</html>