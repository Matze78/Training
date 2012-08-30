<!DOCTYPE html>
<html>

<head> 
<title>Eingabemaske</title>
<meta charset="UTF-8">
<link rel="stylesheet" href="css/navbar.css" type="text/css"> 
</head>

<body>

<h1>Fragen bearbeiten</h1>
<?php 


$script_name = $_SERVER['PHP_SELF'];
echo"<form action='$script_name' method='post'>";

include("navbar.php");
include("zugriff.inc.php");

if (isset($_POST["submit"])){


// Formularwerte in Variablen speichern
$Ueberschrift = mysqli_real_escape_string($db, $_POST["Ueberschrift"]);
$Frage = mysqli_real_escape_string($db, $_POST["Frage"]);
$Tipp = mysqli_real_escape_string($db, $_POST["Tipp"]);
$Antwort = mysqli_real_escape_string($db, $_POST["Antwort"]);

$Inlay = mysqli_real_escape_string($db, $_POST["Inlay"]);
$Tipp = mysqli_real_escape_string($db, $_POST["Tipp"]);
$Schwierigkeitsgrad = mysqli_real_escape_string($db, $_POST["Schwierigkeitsgrad"]);

$Unterpunkt = mysqli_real_escape_string($db, $_POST["Unterpunkt"]);
$Lernstufe = mysqli_real_escape_string($db, $_POST["Lernstufe"]);
$Gedaechtnisstufe = mysqli_real_escape_string($db, $_POST["Gedaechtnisstufe"]);
$Thema = mysqli_real_escape_string($db, $_POST["topics"]);
$Lektion = mysqli_real_escape_string($db, $_POST["units"]);
$Unterpunkt = mysqli_real_escape_string($db, $_POST["Unterpunkt"]);
$Abfrage = mysqli_real_escape_string($db, $_POST["Abfrage"]);
$Status = mysqli_real_escape_string($db, $_POST["Status"]);

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
if (empty ($Abfrage)){
$Abfrage = date('ymd', mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
}





//Fehlertext ausgeben und Skriptabbruch
if($fehler){
 echo"$fehlertext</p>";
 die("</div></body></html>");
}
else {
//Eintrag in die Datenbanktablle
//$datum = date("d.m.Y, H:i"). " Uhr"; */
$sqlbe = "UPDATE `trainer`.`kartei` SET Ueberschrift = '$Ueberschrift', Frage = '$Frage', Antwort = '$Antwort', Inlay = '$Inlay', Tipp ='$Tipp', Schwierigkeitsgrad ='$Schwierigkeitsgrad', Lernstufe = '$Lernstufe', Gedaechtnisstufe = '$Gedaechtnisstufe', Thema = '$Thema', Lektion = '$Lektion', Unterpunkt = '$Unterpunkt', Abfrage = '$Abfrage', Status = '$Status' WHERE id = ". $_POST["id"];

mysqli_query($db, $sqlbe);
//Erfolgsanzeige
if(mysqli_affected_rows($db) >0) {
echo"<h3>Eintrag erfolgreich</h3>";
}
else {
echo"<h3>Eintrag nicht erfolgreich</h3>";
}
}
}


$sqlab = "SELECT * FROM kartei WHERE id = ". $_POST["id"];


$res = mysqli_query($db, $sqlab); //$res wie result
$dsatz = mysqli_fetch_assoc($res);

echo "Überschrift: <br />".
"<input type='text' name='Ueberschrift' maxlength='120' value='".$dsatz["Ueberschrift"]."' /><br />";

echo "Frage:<br />".
"<textarea cols='80' rows='5' name='Frage'>".$dsatz["Frage"] ."</textarea><br />";

echo "Antwort: <br />".
"<textarea cols='80' rows='5' name='Antwort'>".$dsatz["Antwort"] ."</textarea><br />";

echo "Inlay: <br />".
"<textarea cols='80' rows='5' name='Inlay'>".$dsatz["Inlay"] ."</textarea><br />";

echo "Tipp: <br />".
"<textarea cols='80' rows='5' name='Tipp'>".$dsatz["Tipp"] ."</textarea><br />";

echo "Schwierigkeitsgrad: ";
/* "<select name='Schwierigkeitsgrad'>".
"<option selected value".
"<option value='1'>1</option>".
"<option value='2'>2</option>".
"<option value='3'>3</option>".
"<option value='4'>4</option>".
"</select><br />" ; */
//"<input type='text' name='Schwierigkeitsgrad' maxlength='1' value='".$dsatz["Schwierigkeitsgrad"] ."' /><br />";

//Beginn Dropdown Menü Schwierigkeitsgrad

$sql1 = "SELECT * FROM levels ORDER BY id ASC"; //Auswahl Thema
$result1 = mysqli_query($db, $sql1); //Abfrage Thema

echo "<select name='Schwierigkeitsgrad'>"; 

while ($row = mysqli_fetch_assoc($result1)){
		if($row["id"] == $dsatz["Schwierigkeitsgrad"]){
		echo "<option selected value='". $dsatz['Schwierigkeitsgrad'] ."'>". $row['Level'] ."</option>";
		
		}else{
		echo "<option value='". $row['id'] ."'>". $row['Level'] ."</option>";
		}
}//Ende der while-Schleife
echo "</select><br />";
echo "Thema: ";

//Beginn Dropdown Menü Thema

$sql = "SELECT * FROM topics ORDER BY Thema ASC"; //Auswahl Thema
$resultt = mysqli_query($db, $sql); //Abfrage Thema

echo "<select name='topics'>"; 

while ($row = mysqli_fetch_assoc($resultt)){
		if($row["id"] == $dsatz["Thema"]){
		echo "<option selected value='". $dsatz['Thema'] ."'>". $row['Thema'] ."</option>";
		
		}else{
		echo "<option value='". $row['id'] ."'>". $row['Thema'] ."</option>";
		}
}//Ende der while-Schleife
echo "</select><a href='eingabe_topic.php'>neues Thema hinzufügen</a><br />";

//Beginn Dropdown Menü Lektion:

echo "Lektion: ";

$sql = "SELECT * FROM units ORDER BY Lektion ASC"; //Auswahl Thema
$resultl = mysqli_query($db, $sql); //Abfrage Thema

echo "<select name='units'>"; 

while ($row = mysqli_fetch_assoc($resultl)){
		if($row["id"] == $dsatz["Lektion"]){
		echo "<option selected value='". $dsatz['Lektion'] ."'>". $row['Lektion'] ."</option>";
		
		}else{
		echo "<option value='". $row['id'] ."'>". $row['Lektion'] ."</option>";
		}
}//Ende der while-Schleife
echo "</select><br />";


echo "Tag: ".
"<input type='text' name='Unterpunkt' maxlength='40' value='".$dsatz["Unterpunkt"] ."' /><br />";

echo "Lernstufe: ".
"<input type='text' name='Lernstufe' maxlength='1' value='".$dsatz["Lernstufe"] ."' /><br />";

echo "Gedächtnisstufe: ".
"<input type='text' name='Gedaechtnisstufe' maxlength='1' value='".$dsatz["Gedaechtnisstufe"] ."' /><br />";

echo "Datum der nächsten Abfrage: ".
"<input type='text' name='Abfrage' maxlength='8' value='".$dsatz["Abfrage"] ."' /><br />";

echo "Status: ".
"<input type='text' name='Status' maxlength='1' value='".$dsatz["Status"] ."' /><br />";


if(isset($_POST['nr'])){
$nr = $_POST['nr'];
}else{
$nr = 0;
}
echo"<input type='hidden' name='back' value='".$nr."' />";

echo "<input type='reset' value='Zurücksetzen' name='reset'>".
"<input type='submit' value='Eintragen!' name='submit'><input type='hidden' name='id' value='".$dsatz["id"]."'></form>"; //Ende des Formulars

if (isset($_POST["back"])){
echo "<a href='abfrage.php?start=".$_POST['back']."'>zurück</a>";

}


//include("zugriff.inc.php");




mysqli_close($db);
?>


</body>

</html>