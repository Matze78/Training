<!DOCTYPE html>
<html>

<head> 
<title>Eingabemaske</title>
<meta charset="UTF-8">

</head>

<body>
<div style="width: 600px">
<h1>Fragen bearbeiten</h1>
<?php 
$script_name = $_SERVER['PHP_SELF'];
echo'<form action="'.$script_name.'" method="post">';

include("zugriff.inc.php");

if (isset($_POST["submit"])){
// Formularwerte in Variablen speichern
$Frage = mysqli_real_escape_string($db, $_POST["Frage"]);
$Antwort = mysqli_real_escape_string($db, $_POST["Antwort"]);
$Tipp = mysqli_real_escape_string($db, $_POST["Tipp"]);
$Schwierigkeitsgrad = mysqli_real_escape_string($db, $_POST["Schwierigkeitsgrad"]);
$Thema = mysqli_real_escape_string($db, $_POST["Thema"]);
$Lektion = mysqli_real_escape_string($db, $_POST["Lektion"]);
$Unterpunkt = mysqli_real_escape_string($db, $_POST["Unterpunkt"]);
$Lernstufe = mysqli_real_escape_string($db, $_POST["Lernstufe"]);
$Gedaechtnisstufe = mysqli_real_escape_string($db, $_POST["Gedaechtnisstufe"]);
$Thema = mysqli_real_escape_string($db, $_POST["Thema"]);
$Lektion = mysqli_real_escape_string($db, $_POST["Lektion"]);
$Unterpunkt = mysqli_real_escape_string($db, $_POST["Unterpunkt"]);
// $Abfrage = mysqli_real_escape_string($db, 1);

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
$sqlbe = "UPDATE `trainer`.`kartei` SET Frage = '$Frage', Antwort = '$Antwort', Tipp ='$Tipp', Schwierigkeitsgrad ='$Schwierigkeitsgrad', Lernstufe = '$Lernstufe', Gedaechtnisstufe = '$Gedaechtnisstufe', Thema = '$Thema', Lektion = '$Lektion', Unterpunkt = '$Unterpunkt' WHERE id = ". $_POST["id"];

//(`id`, `Frage`, `Antwort`, `Tipp`, `Schwierigkeitsgrad`, `Thema`, `Lektion`, `Unterpunkt`) SET('','$Frage','$Antwort', '$Tipp','$Schwierigkeitsgrad', '$Thema', '$Lektion', '$Unterpunkt')";
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


echo "Frage:<br />".
"<textarea cols='80' rows='5' name='Frage'>".$dsatz["Frage"] ."</textarea><br />";

echo "Antwort: <br />".
"<textarea cols='80' rows='5' name='Antwort'>".$dsatz["Antwort"] ."</textarea><br />";

echo "Tipp: <br />".
"<textarea cols='80' rows='5' name='Tipp'>".$dsatz["Tipp"] ."</textarea><br />";

echo "Schwierigkeitsgrad:". 
"<input type='text' name='Schwierigkeitsgrad' maxlength='1' value='".$dsatz["Schwierigkeitsgrad"] ."' /><br />";

echo "Thema:".
"<input type='text' name='Thema' maxlength='40' value='".$dsatz["Thema"] ."'/><br />";

echo "Lektion:".
"<input type='text' name='Lektion' maxlength='40' value='".$dsatz["Lektion"] ."'/><br />";

echo "Unterpunkt:".
"<input type='text' name='Unterpunkt' maxlength='40' value='".$dsatz["Unterpunkt"] ."' /><br />";

echo "Lernstufe:".
"<input type='text' name='Lernstufe' maxlength='1' value='".$dsatz["Lernstufe"] ."' /><br />";

echo "Gedächtnisstufe:".
"<input type='text' name='Gedaechtnisstufe' maxlength='1' value='".$dsatz["Gedaechtnisstufe"] ."' /><br />";


echo "<input type='reset' value='Zurücksetzen' name='reset'>".
"<input type='submit' value='Eintragen!' name='submit'><input type='hidden' name='id' value='".$dsatz["id"]."'></form>";



include("zugriff.inc.php");




mysqli_close($db);
?>
</div>

</body>

</html>