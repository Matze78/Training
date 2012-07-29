<!DOCTYPE html>
<html>

<head> 
<title>Ausgabe</title>
<meta charset="UTF-8">

</head>

<body>
<div style="width: 600px">
<h1>Ausgabe</h1>

<?php 
$script_name = $_SERVER['PHP_SELF'];
$start = 0; // Startwert setzen (0 = 1. Zeile)
$step = 1; // Wie viele Einträge gleichzeitig?
// Startwert verändern:
if (isset($_GET["start"])){
$muster = "/^[0-9]+$/"; // regl. Ausdruck für Zahlen
if (preg_match($muster, $_GET["start"]) == 0){
	$start = 0; // Bei Manipulation Rückfall auf 0
	} else {
	$start = $_GET["start"];
	}
}
$nr = $start +1;
include("zugriff.inc.php");


$sql1 = "SELECT * FROM kartei"; // SQL-Abfrage - Alles aus der Datei wird eingelesen
$sql2 = "SELECT * FROM kartei ORDER BY id DESC LIMIT $start, $step";
$result1 = mysqli_query($db, $sql1);
$zeilen = mysqli_num_rows($result1);
$result2 = mysqli_query($db, $sql2);
for($i =0; $zeilen > $i; $i = $i + $step){
$anf = $i +1;
$end = $i + $step;
echo "[<a href=\"ausgabe.php?start=$i\">$anf-$end</a>]";
}
echo "<p>Anzahl der Einträge: $zeilen</p>\n";
// while-Schleife Anfang
while ($row = mysqli_fetch_assoc($result2)){
echo"<div id='question'><p><strong>$nr.</strong> <b>"  . nl2br(htmlspecialchars($row["Frage"])) . "</b><p></div> ";




if (!empty($row["Tipp"])) {
echo "(".htmlspecialchars($row["Tipp"]) . ")";
}

	"<strong>". nl2br(htmlspecialchars($row["Antwort"])) .
	"</p><hr>\n";
	$nr++;
} //while Ende


mysqli_close($db);
?>
</div>

</body>

</html>