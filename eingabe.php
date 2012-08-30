<!DOCTYPE html>
<html>

<head> 
<title>Eingabemaske</title>
<meta charset="UTF-8">
<link rel="stylesheet" href="css/navbar.css" type="text/css" />
<link rel="stylesheet" href="css/general.css" type="text/css" />

</head>

<body>
<div id="wrapper">
<h1>Eingabe der Fragen</h1>

<?php 

$script_name = $_SERVER['PHP_SELF'];

include("navbar.php");

if(isset($_POST["topics"])){
echo "Thema gesetzt auf: ".$_POST["topics"];
}
echo'<form action="eingabe.php" method="post">';
echo"Thema: ";
include("zugriff.inc.php");
$sql = "SELECT * FROM topics";
$result = mysqli_query($db, $sql);

echo "<select name='topics'>"; //Dropdown Menü für Thema

while ($row = mysqli_fetch_assoc($result)){
		if(isset($_POST["topics"]) && $_POST["topics"] == $row["id"]){
		echo "<option selected value='". $row['id'] ."'>". $row['Thema'] ."</option>";
		
		}else{
		echo "<option value='". $row['id'] ."'>". $row['Thema'] ."</option>";
		}
}//Ende der while-Schleife
echo "</select>";

$sql = "SELECT * FROM units";
$result = mysqli_query($db, $sql);
echo "<select name='units'>"; // Dropdown Menü für Lektion
while ($row = mysqli_fetch_assoc($result)){
		if(isset($_POST["units"]) && $_POST["units"] == $row["id"]){
		echo "<option selected='selected' value='". $row['id'] ."'>". $row['Lektion'] ."</option>";
		
		}else{
		echo "<option value='". $row['id'] ."'>". $row['Lektion'] ."</option>";
		}
}//Ende der while-Schleife
echo "</select>";


?>
<br />Überschrift : <input type="text" name="Ueberschrift" maxlength="120" size="60" />

<br />Frage:<br />
<textarea cols="80" rows="5" name="Frage"></textarea><br />

Antwort: <br />
<textarea cols="80" rows="5" name="Antwort"></textarea><br />

Inlay: <br />
<textarea cols="80" rows="5" name="Inlay"></textarea><br />

Tipp: <br />
<textarea cols="80" rows="5" name="Tipp"></textarea><br />

Schwierigkeitsgrad: 
<!--<input type="text" name="Schwierigkeitsgrad" maxlength="1" /><br />-->
<select name='Schwierigkeitsgrad'>
<option value="1">leicht</option>
<option selected="selected" value="2">normal</option>
<option value="3">anspruchsvoll</option>
<option value="4">schwer</option>
</select><br />



Tag: 
<input type="text" name="Unterpunkt" maxlength="40" size="40" /><br />

Status:
<select name="Status">
<option value="1" >inaktiv</option>
<option selected="selected" value="2" >aktiv</option>
<option value="3" >gelernt</option>
<br />
<input type="submit" value="Eintragen!" name="submit">
</form>

<?php

include("zugriff.inc.php");
//Formular abgesendet?

$LS = 1;
$GS = 1;
$Datum =  date('ymd', mktime(0, 0, 0, date("m")  , date("d"), date("Y")));



if (isset($_POST["submit"])){
// Formularwerte in Variablen speichern
$Ueberschrift = mysqli_real_escape_string($db, $_POST["Ueberschrift"]);
$Frage = mysqli_real_escape_string($db, $_POST["Frage"]);
$Antwort = mysqli_real_escape_string($db, $_POST["Antwort"]);
$Inlay = mysqli_real_escape_string($db, $_POST["Inlay"]);
$Tipp = mysqli_real_escape_string($db, $_POST["Tipp"]);
$Schwierigkeitsgrad = mysqli_real_escape_string($db, $_POST["Schwierigkeitsgrad"]);
$Unterpunkt = mysqli_real_escape_string($db, $_POST["Unterpunkt"]);
$Lernstufe = mysqli_real_escape_string($db, $LS);
$Gedaechtnisstufe = mysqli_real_escape_string($db, $GS);
$Thema = mysqli_real_escape_string($db, $_POST["topics"]);
$Lektion = mysqli_real_escape_string($db, $_POST["units"]);
$Unterpunkt = mysqli_real_escape_string($db, $_POST["Unterpunkt"]);
$Abfrage = mysqli_real_escape_string($db, $Datum);


$fehler = false;
$fehlertext ="";

//Eingabe prüfen und Felertext zusammensetzen

if (empty($Frage)){
$fehler = true;
$fehlertext .= "Die Frage fehlt<br />";
}
if (empty($Antwort)){
$fehler = true;
$fehlertext.="Bitte eine Antwort eintragen!<br />";
}
if (empty($Inlay)){
$Inlay = "";
}
if (empty($Tipp)){
$Tipp = "";
}
if (empty($Schwierigkeitsgrad)){
$Schwierigkeitsgrad = 1;
}
if (empty($Thema)){
$Thema = "";
}
if (empty($Lektion)){
$Lektion = "";
}
if (empty($Unterpunkt)){
$Unterpunkt = "";
}
if (empty($Lernstufe)){
$Lernstufe = 1;
}
if (empty ($Gedaechtnisstufe)){
$Gedaechtnisstufe = 1;
}




//Fehlertext ausgeben und Skriptabbruch
if($fehler){
 echo"$fehlertext</p>";
 die("</div></body></html>");
}
else {
//Eintrag in die Datenbanktablle
//$datum = date("d.m.Y, H:i"). " Uhr"; */
$sql = "INSERT INTO `trainer`.`kartei` (`id`, `Ueberschrift`, `Frage`, `Antwort`, `Inlay`, `Tipp`, `Schwierigkeitsgrad`, `Lernstufe`, `Gedaechtnisstufe`, `Thema`, `Lektion`, `Unterpunkt`, `Abfrage`) VALUES('$Ueberschrift','','$Frage','$Antwort', '$Inlay', '$Tipp','$Schwierigkeitsgrad', '$Lernstufe', '$Gedaechtnisstufe', '$Thema', '$Lektion', '$Unterpunkt', '$Abfrage')";
mysqli_query($db, $sql);
//Erfolgsanzeige
if(mysqli_affected_rows($db) >0) {
echo"<h3>Eintrag erfolgreich</h3>";
}
else {
echo"<h3>Eintrag nicht erfolgreich</h3>";
}
}
}


mysqli_close($db);
?>
</div>

</body>

</html>