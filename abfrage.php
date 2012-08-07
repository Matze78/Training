<!DOCTYPE html>
<html>

<head> 
<title>Abfrage</title>
<meta charset="UTF-8">

<script type="text/javascript" src="js/shortcut.js"> </script> <!--JS für die Tastenkürzel -->
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>

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

shortcut.add("Tab",function() { //Lösung anzeigen
	window.$('[accesskey=tab]').click();
},{
	'type':'keydown',
	'propagate':true,
	'target':document
});

shortcut.add("j",function() { //Antwort war richtig
	window.$('[accesskey=j]').click();
},{
	'type':'keydown',
	'disable_in_input':true,
	'propagate':true,
	'target':document
});

shortcut.add("f",function() { //Antwort war richtig
	window.$('[accesskey=j]').click();
},{
	'type':'keydown',
	'disable_in_input':true,
	'propagate':true,
	'target':document
});

shortcut.add("n",function() { //Antwort war richtig
	window.$('[accesskey=j]').click();
},{
	'type':'keydown',
	'disable_in_input':true,
	'propagate':true,
	'target':document
});

</script>

</head>
<?php // Abfrage, ob Fragebox in den Fokus soll
if (empty($_POST["frage"])){
echo "<body OnLoad='document.eingabe.frage.focus();'>"; 
}
else{
echo "<body>";
}
?>

<div style="width: 600px">
<h1>Abfrage</h1>
<script>

</script>

<?php 
error_reporting(E_ALL);  
session_start(); 

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
	 if ($_SESSION["Sprung"] == false){
		$start = $_GET["start"];
		} else {
		$start = $_GET["start"]-1;
			if ($start < 0) {
			$start = 0;
			}
		
		}
	}
}
$nr = $start +1;
include("zugriff.inc.php");

$sql1 = $_SESSION['abfrage1']; // SQL-Abfrage - Alles aus der Datei wird eingelesen

$sql2 = $_SESSION['abfrage2'].$start. ", ". $step;

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
//Anzeige des Themas
echo"<p>Thema: ".$row['Thema']."</p>";
echo"<div id='question'><p><h3>Frage Nr. $nr:</h3>"  . nl2br(htmlspecialchars($row["Frage"])) . "<p></div> ";
if ($row["Tipp"]!=""){
echo"<div id='tipp' style='display:none'><p>".$row["Tipp"]." </p></div>";
echo"<input id='button_tipp' type='button' value='Tipp' onClick='tipp_anzeigen1();' style='display:block'>";
}


//mögliches Problem: <form action='#'>
echo "<div id='formular'><form name='eingabe' action='#' method='post'><p><textarea name='frage' rows='10' cols='70' autocomplete='off' />";

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
echo "<p><input type='submit' value='Lösung anzeigen' accesskey='tab' /><input type='reset' /></p></form></div>";


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

	$next=1;
	if (!empty($_GET["start"])) {
			$next = $_GET["start"]+1;
			if ($next == $zeilen){
				$next = 0;
				}
			}

	echo "<form name='Auswertung' action='".$fileName."?start=$next' method='Post'>"; //was wird als nächstes gefragt? IDEE: Steuerung über If's und next
	echo "<input name='Ergebnis' type='hidden' value='' />";
	echo "<input name='Zeile' type='hidden' value='".$row["id"]."'>";
	echo "<input type='button' value='Nein' onclick='lernstufe(0)' accesskey='n' /> <input type='button' value='Fast' onclick='lernstufe(1)' accesskey='f'/>"." <input type='button' value='Ja' onclick='lernstufe(2)' accesskey='j' />";
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