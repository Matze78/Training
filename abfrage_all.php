<!DOCTYPE html>
<html>

<head> 
<title>Abfrage</title>
<meta charset="UTF-8">
<script>
function tipp_anzeigen1() {
	document.getElementById("tipp").style.display='block';
		if(document.getElementById("tipp").style.display =='block')
		{
		document.getElementById("button_tipp").style.display='none';
		}
};


function lernstufe(wert){
	if (wert == 0){
	document.Auswertung.Ergebnis.value = "nein";
	}
	if (wert == 1){
	document.Auswertung.Ergebnis.value = "fast";
	}
	if (wert == 2){
	document.Auswertung.Ergebnis.value = "ja";
	}
	
document.Auswertung.submit();

};
</script>

</head>

<body>
<div style="width: 600px">
<h1>Abfrage</h1>

<?php 
$fileName = $_SERVER['PHP_SELF'];
$datum = date('ymd', mktime(0, 0, 0, date("m")  , date("d"), date("Y")))*1;


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
$sql3 = "SELECT * FROM kartei WHERE Abfrage <= ". $datum ."";
$sql4 = "SELECT * FROM kartei WHERE Abfrage <= ". $datum ." ORDER BY id ASC LIMIT $start, $step";
$result1 = mysqli_query($db, $sql1);
$zeilen = mysqli_num_rows($result1);
$result2 = mysqli_query($db, $sql2);
for($i =0; $zeilen > $i; $i = $i + $step){
$anf = $i +1;
$end = $i + $step;

echo "[<a href=".$fileName."?start=$i>$anf-$end</a>] ";
}


echo "<p>Anzahl der Einträge: $zeilen</p>\n";


// while-Schleife Anfang
while ($row = mysqli_fetch_assoc($result2)){
echo"<div id='question'><p><h3>Frage Nr. $nr:</h3>"  . nl2br(htmlspecialchars($row["Frage"])) . "<p></div> ";
if ($row["Tipp"]!=""){
echo"<div id='tipp' style='display:none'><p>".$row["Tipp"]." </p></div>";
echo"<input id='button_tipp' type='button' value='Tipp' onClick='tipp_anzeigen1();' style='display:block'>";
}


//mögliches Problem: <form action='#'>
echo "<div id='formular'><form action='#' method='post'><p><textarea name='frage' rows='10' cols='70' autocomplete='off' />";

if (isset($_POST["frage"])){
$convert1 = Array("<",">","\n","$");
  		$convert2 = Array("&lt;","&gt;","\n","&#36;");
		$output1 = str_replace($convert1, $convert2, $_POST["frage"]);
		echo $output1;
}

echo "</textarea></p>";
//Anzeige der Lern- und Gedächtnisstufe und Datum der nächsten Abfrage
echo "<p>Lernstufe: ".$row['Lernstufe']." Gedächtnisstufe: ".$row['Gedaechtnisstufe']. " nächstes Abfragedatum: ". $row['Abfrage'] ."</p>";
// Button: Lösung anzeigen / Zurücksetzen
echo "<p><input type='submit' value='Lösung anzeigen' /><input type='reset' /></p></form></div>";


//Datensatz bearbeiten button
$back = 0;
if(!empty($_GET["start"])){
$back = $_GET["start"];
}
echo"<form action='bearbeiten.php' method='Post'><input type='hidden' name='id' value='".$row["id"]."'><input type='hidden' name='nr' value='".$back."' /><input type='submit' name='bearbeiten' value='bearbeiten'/> </form>";

//Anfang des Antwortdialoges
if (isset($_POST["frage"])){
	echo nl2br(htmlspecialchars($row["Antwort"]));
	
	// Ermittlung der Lern- und Gedächtnisstufe
	echo "<p>War die Antwort richtig?</p>";

	$next=0;
	if (!empty($_GET["start"])) {
			$next = $_GET["start"]+1;
			}

	echo "<form name='Auswertung' action='".$fileName."?start=$next' method='Post'>"; //was wird als nächstes gefragt? IDEE: Steuerung über If's und next
	echo "<input name='Ergebnis' type='hidden' value='' />";
	echo "<input name='Zeile' type='hidden' value='".$row["id"]."'>";
	echo "<input type='button' value='Nein' onclick='lernstufe(0)'/> <input type='button' value='Fast' onclick='lernstufe(1)' />"." <input type='button' value='Ja' onclick='lernstufe(2)' />";
	echo "</form>";

} // Ende Antwortdialog

require("progress.php"); //PHP Auswertungsskript WICHTIG: Nicht in den Antwortdialog setzen!

$nr++;

	
} //while Ende




mysqli_close($db);
?>
</div>

</body>

</html>