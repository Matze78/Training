<!DOCTYPE html>
<html>

<head> 
<title>Abfrage</title>
<meta charset="UTF-8">
<script>function tipp_anzeigen1() 
{document.getElementById("tipp").style.display='block';
		if(document.getElementById("tipp").style.display =='block')
		{
		document.getElementById("button_tipp").style.display='none';
		}
}
</script>

</head>

<body>
<div style="width: 600px">
<h1>Abfrage</h1>

<?php 
//$script_name = $_SERVER['PHP_SELF'];
$script_name = "#";
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
$sql2 = "SELECT * FROM kartei ORDER BY id ASC LIMIT $start, $step";
$result1 = mysqli_query($db, $sql1);
$zeilen = mysqli_num_rows($result1);
$result2 = mysqli_query($db, $sql2);
for($i =0; $zeilen > $i; $i = $i + $step){
$anf = $i +1;
$end = $i + $step;
echo "[<a href=\"abfrage2.php?start=$i\">$anf-$end</a>]";
}
echo "<p>Anzahl der Einträge: $zeilen</p>\n";
// while-Schleife Anfang
while ($row = mysqli_fetch_assoc($result2)){
echo"<div id='question'><p><h3>Frage Nr. $nr:</h3>"  . nl2br(htmlspecialchars($row["Frage"])) . "<p></div> ";
if ($row["Tipp"]!=""){
echo"<div id='tipp' style='display:none'><p>".$row["Tipp"]." </p></div>";
echo"<input id='button_tipp' type='button' value='Tipp'
onClick='tipp_anzeigen1();' style='display:block'>";
}



echo "<div id='formular'><form action='$script_name' method='post'><p><textarea name='frage' rows='10' cols='70' autocomplete='off' />";

if (isset($_POST["frage"])){
$convert1 = Array("<",">","\n","$");
  		$convert2 = Array("&lt;","&gt;","\n","&#36;");
		$output1 = str_replace($convert1, $convert2, $_POST["frage"]);
		echo $output1;
}

echo "</textarea></p><p><input type='submit' value='Lösung anzeigen' /><input type='reset' /></p></form></div>";
//hier soll eine "Datensatz bearbeiten Button" hin
echo"<form action='bearbeiten.php' method='Post'><input type='hidden' name='id' value='".$row["id"]."'><input type='submit' name='bearbeiten' value='bearbeiten'/> </form>";


if (isset($_POST["frage"])){
	echo nl2br(htmlspecialchars($row["Antwort"]));
	echo "<p>War die Antwort richtig?</p>";
}

/*
if (!empty($row["Antwort"])) {
echo "(".htmlspecialchars($row["Antwort"]) . ")";
}
*/
	
	$nr++;

	
} //while Ende


mysqli_close($db);
?>
</div>

</body>

</html>