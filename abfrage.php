<!DOCTYPE html>
<html>

<head> 
<title>Abfrage</title>
<meta charset="UTF-8">

<script type="text/javascript" src="js/shortcut.js"> </script> <!--JS für die Tastenkürzel -->
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<link rel="stylesheet" href="css/navbar.css" type="text/css">
<link rel="stylesheet" href="css/general.css" type="text/css">

<script>
function tipp_anzeigen1() {
	document.getElementById("hint").style.display='block';
		if(document.getElementById("hint").style.display =='block')
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
	if (wert == 3){
	document:Auswertung.Ergebnis.value = "gelernt";
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

shortcut.add("f",function() { //Antwort war nicht richtig
	window.$('[accesskey=f]').click();
},{
	'type':'keydown',
	'disable_in_input':true,
	'propagate':true,
	'target':document
});

shortcut.add("n",function() { //Antwort fast richtig
	window.$('[accesskey=n]').click();
},{
	'type':'keydown',
	'disable_in_input':true,
	'propagate':true,
	'target':document
});

shortcut.add("g",function() { //nächste Lernstufe erreicht
	window.$('[accesskey=g]').click();
},{
	'type':'keydown',
	'disable_in_input':true,
	'propagate':true,
	'target':document
});



</script>
<script type="text/javascript"
   src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
</script>

</head>
<?php 
// Abfrage, ob Fragebox in den Fokus soll
if (empty($_POST["frage"])){
echo '<body onload="document.eingabe.frage.focus();">'; 
}
else{
echo "<body>";
}
session_start(); 
include("navbar.php");//Navbar
include("functions.php");//PHP-Funktionen
require("progress.php"); //PHP Auswertungsskript




$fileName = $_SERVER['PHP_SELF'];
$datum = date('ymd', mktime(0, 0, 0, date("m")  , date("d"), date("Y")))*1;


include("zugriff.inc.php");
$sql1 = $_SESSION['abfrage1'];
$result1 = mysqli_query($db, $sql1);
$zeilen = mysqli_num_rows($result1);

/* Debug Code
echo "<div>";
echo "Zeilen: ".$zeilen;
echo "</div>";
*/


if($zeilen == 0){
	header ("HTTP/1.1 301 Moved Permanently"); 
	header ("Location: Abfrage_finished.php"); 
}


$start = 0; // Startwert setzen (0 = 1. Zeile)
$step = 1; // Wie viele Einträge gleichzeitig?
// Startwert verändern:

if (isset($_GET["start"])){

$muster = "/^[0-9]+$/"; // regl. Ausdruck für Zahlen
if (preg_match($muster, $_GET["start"]) == 0){
	$start = 0; // Bei Manipulation Rückfall auf 0
	} 
else if ($_GET["start"] >= $zeilen){
$start = 0;
}
	
else if($_SESSION["zeil"] == 1){
	$start = 0;
	}
else If($_SESSION["zeil"] == 1 && $_SESSION["Sprung"]== true){
		echo"Abfrage fertig!";
		}
else If($_SESSION["zeil"] == 1 && $_SESSION["Sprung"]== false){
		$start = 0;
		$_GET["start"]=$start;
		}
else{
	 if ($_SESSION["Sprung"] == false){
		$start = $_GET["start"];
		} else {
		$start = $_GET["start"]-1;
			if($start < 0) {
			$start = 0;
			}
		
		}
	}

/* Debug Code	
echo "<div>";
echo "start: ".$start;
echo "</div>";
*/

}

$nr = $start +1;


$sql1 = $_SESSION['abfrage1']; // SQL-Abfrage - Alles aus der Datei wird eingelesen
$sql2 = $_SESSION['abfrage2'].$start. ", ". $step;
$result1 = mysqli_query($db, $sql1);
$zeilen = mysqli_num_rows($result1); //Definition der Zeilen
$_SESSION["zeil"] = $zeilen;
$result2 = mysqli_query($db, $sql2);




// while-Schleife Anfang

//Anzeige des Themas / der Lektion
//while ($row = mysqli_fetch_assoc($result2)){ //hier ist ein Problem while 
do {$row = mysqli_fetch_assoc($result2);

if(!empty($row["Thema"]) || !empty($row["Lektion"])){ //Sicherheitsabfrage falls Thema oder Lektion leer
$sql3 = "SELECT * FROM topics WHERE id =".$row["Thema"]; //Abfragestring Thema (interne Nr. 3)
$sql4 = "SELECT * FROM units WHERE id =".$row["Lektion"]; //Abfragestring Lektion (interne Nr. 4)
$result3 = mysqli_query($db, $sql3); 
$result4 = mysqli_query($db, $sql4);
$row3 = mysqli_fetch_assoc($result3); 
$row4 = mysqli_fetch_assoc($result4);
//div Wrapper
echo"<div id='wrapper'>";

echo "<div id='topic'>".$row3['Thema']." | ".$row4['Lektion']." | Frage Nr.: ".$nr."</div>"; //Anzeige von Thema / Lektion / Frage-Nr
}
if(!empty($row["Ueberschrift"])){ //Anzeige der Überschrift
echo"<div id='heading'>".$row["Ueberschrift"]."</div>";
}

//===Anzeige der Frage
$question = nl2br(htmlspecialchars($row["Frage"]));
$convert3 = Array("[code]", "[/code]", "[img]", "[/img]" ); //html-Befehle
$convert4 = Array("<code>", "</code>", "<img", "/>" );

$output00 = str_replace($convert3, $convert4, $question);
echo "<div id='left'>"; //Anfang Left
echo "<div id='question'>".$output00 . "</div>"; //#question Frage wird angezeigt

//Tipp anzeigen
if ($row["Tipp"]!=""){
$tipp = nl2br(htmlspecialchars($row["Tipp"]));
$convert5 = Array("[code]", "[/code]", "[img]", "[/img]" ); //html-Befehle
$convert6 = Array("<code>", "</code>", "<img", "/>" );
$output11 = str_replace($convert5, $convert6, $tipp);

echo"<div id='hint' style='display:none'><p>".$output11." </div>"; //#Tipp
echo"<div id='button_hint'><input id='button_tipp' type='button' value='Tipp' onClick='tipp_anzeigen1();' style='display:block' ></div>"; 
}
//Ende Tipp anzeigen

//Datensatz bearbeiten button
$back = 0;
if(!empty($_GET["start"])){
$back = $_GET["start"];
}
echo"<div id='button_edit'><form action='bearbeiten.php' method='Post'><input type='hidden' name='id' value='".$row["id"]."'><input type='hidden' name='nr' value='".$back."' /><input type='submit' name='bearbeiten' value='bearbeiten'/> </form></div>";
//Ende Datensatz bearbeiten

//Anfang Infos
$result2 = mysqli_query($db, $sql2);
$rowxx = mysqli_fetch_assoc($result2);
echo "<div id='info'>Schwierigkeitsgrad: ".$rowxx['Schwierigkeitsgrad']."<br />".
"Lernstufe: ".$rowxx['Lernstufe']." - Gedächtnisstufe: ".$rowxx['Gedaechtnisstufe'].
"<br />nächstes Abfrage am: ". dconvert($rowxx['Abfrage']) ."</div>";
//Ende Infos

echo "</div>"; //Ende Left
echo "<div id='right'>"; //Anfang Right
//Anfang Formular Texteinage
echo "<form name='eingabe' action='#' method='post'><textarea name='frage' rows='10' cols='65' autocomplete='off'>";

//Abfrage für den Inlay-Text
if (!isset($_POST["frage"])){
$convert1 = Array("<",">","\n","$");
  		$convert2 = Array("&lt;","&gt;","\n","&#36;");
		$output1 = str_replace($convert1, $convert2, $row["Inlay"]);
		echo $output1;}

//Abfrage für die abgeschickte Antwort		
if (isset($_POST["frage"])){
$convert1 = Array("<",">","\n","$"); //Umwandlung der Eingegebenen Zeichen
  		$convert2 = Array("&lt;","&gt;","\n","&#36;");
		$output1 = str_replace($convert1, $convert2, $_POST["frage"]);
		echo $output1;
}

echo "</textarea>"; //Ende der Abfrage-Box

// Button: Lösung anzeigen / Zurücksetzen
echo "<div id='button_answer'><input type='submit' value='Lösung anzeigen' accesskey='tab' /><input type='reset' /></div></form>"; //#Ende formular
//Ende Formular Texteingabe


//Anfang des Antwortdialoges
if (isset($_POST["frage"])){
//===Anzeige der Antwort==

$answer = nl2br(htmlspecialchars($row["Antwort"]));
$convert3 = Array("[code]", "[/code]", "[img]", "[/img]" ); //html-Befehle
$convert4 = Array("<code>", "</code>", "<img", "/>" );

$output0 = str_replace($convert3, $convert4, $answer);

echo $output0; //Ausgabe der Anwort
	
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
	echo "<input type='button' value='Nein' onclick='lernstufe(0)' accesskey='n' /> <input type='button' value='Fast' onclick='lernstufe(1)' accesskey='f'/>"." <input type='button' value='Ja' onclick='lernstufe(2)' accesskey='j' /> <input type='button' value='gelernt' onclick='lernstufe(3)' accesskey='g' />";
	echo "</form>";

} // Ende Antwortdialog
echo "</div>"; //Ende Right


$nr++;

	
}while ($row = mysqli_fetch_assoc($result2)); //Ende der Do-While-Schleife
echo "</div>"; //Wrapper Ende


//echo "<p>Anzahl der Einträge: $zeilen</p>\n";
echo "<div id='nav_2'>";
for($i =0; $zeilen > $i; $i = $i + $step){
$anf = $i +1;
$end = $i + $step;

echo "[<a href=".$fileName."?start=$i>$anf</a>] ";
}
echo "</div>";//Ende von #nav_2
mysqli_close($db);
?>


</body>

</html>