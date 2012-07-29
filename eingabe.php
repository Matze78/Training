<!DOCTYPE html>
<html>

<head> 
<title>Eingabemaske</title>
<meta charset="UTF-8">

</head>

<body>
<div style="width: 600px">
<h1>Eingabe der Fragen</h1>
<?php 
$script_name = $_SERVER['PHP_SELF'];
echo'<form action="'.$script_name.'" method="post">';
?>

Frage:<br />
<textarea cols="80" rows="5" name="Frage"></textarea><br />

Antwort: <br />
<textarea cols="80" rows="5" name="Antwort"></textarea><br />

Tipp: <br />
<textarea cols="80" rows="5" name="Tipp"></textarea><br />

Schwierigkeitsgrad: 
<input type="text" name="Schwierigkeitsgrad" maxlength="1" /><br />

Thema:
<input type="text" name="Thema" maxlength="40" /><br />

Lektion:
<input type="text" name="Lektion" maxlength="40" /><br />

Unterpunkt:
<input type="text" name="Unterpunkt" maxlength="40" /><br />

<input type="reset" value="Zurücksetzen" name="reset">
<input type="submit" value="Eintragen!" name="submit">
</form>

<?php
// $start = 0; // Startwert setzen (0 = 1. Zeile)
//$step = 1; // Wie viele Einträge gleichzeitig?
// Startwert verändern:
//if (isset($_GET["start"])){
//$muster = "/^[0-9]+$/"; // regl. Ausdruck für Zahlen
//if (preg_match($muster, $_GET["start"]) == 0){
//	$start = 0; // Bei Manipulation Rückfall auf 0
//	} else {
//	$start = $_GET["start"];
//	}
//}
//$nr = $start +1;
include("zugriff.inc.php");
//Formular abgesendet?

$LS = 1;
$GS = 1;



if (isset($_POST["submit"])){
// Formularwerte in Variablen speichern
$Frage = mysqli_real_escape_string($db, $_POST["Frage"]);
$Antwort = mysqli_real_escape_string($db, $_POST["Antwort"]);
$Tipp = mysqli_real_escape_string($db, $_POST["Tipp"]);
$Schwierigkeitsgrad = mysqli_real_escape_string($db, $_POST["Schwierigkeitsgrad"]);
$Thema = mysqli_real_escape_string($db, $_POST["Thema"]);
$Lektion = mysqli_real_escape_string($db, $_POST["Lektion"]);
$Unterpunkt = mysqli_real_escape_string($db, $_POST["Unterpunkt"]);
$Lernstufe = mysqli_real_escape_string($db, $LS);
$Gedaechtnisstufe = mysqli_real_escape_string($db, $GS);
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
$sql = "INSERT INTO `trainer`.`kartei` (`id`, `Frage`, `Antwort`, `Tipp`, `Schwierigkeitsgrad`, `Lernstufe`, `Gedaechtnisstufe`, `Thema`, `Lektion`, `Unterpunkt`) VALUES('','$Frage','$Antwort', '$Tipp','$Schwierigkeitsgrad', '$Lernstufe', '$Gedaechtnisstufe', '$Thema', '$Lektion', '$Unterpunkt')";
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
/*
$sql1 = "SELECT * FROM kartei";
$sql2 = "SELECT * FROM kartei ORDER BY id DESC LIMIT $start, $step";
$result1 = mysqli_query($db, $sql1);
$zeilen = mysqli_num_rows($result1);
$result2 = mysqli_query($db, $sql2);
for($i =0; $zeilen > $i; $i = $i + $step){
$anf = $i +1;
$end = $i + $step;
echo "[<a href=\"]".$script_name."[?start=$i\">$anf-$end</a>]";
}
echo "<h2>Bisherige Einträge:</h2>";
echo "<p>Anzahl der Einträge: $zeilen</p>\n";
// while-Schleife Anfang
while ($row = mysqli_fetch_assoc($result2)){
echo"<p><strong>$nr.</strong> <b>" . htmlspecialchars($row["Name"]) . "</b> ";
if (!empty($row["Home"])) {
echo "(".htmlspecialchars($row["Home"]) . ")";
}
echo "<br>--&gt; schrieb am "."<strong>".$row["Datum"]."</strong:</p>" .
	"<strong>". nl2br(htmlspecialchars($row["Kommentar"])) .
	"</p><hr>\n";
	$nr++;
} //while Ende

*/
mysqli_close($db);
?>
</div>

</body>

</html>