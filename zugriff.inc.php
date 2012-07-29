<?php
$db = @mysqli_connect("localhost","root","")
	or die("Die Verbindung zu MySQL ist gescheitert!");
mysqli_set_charset($db, "utf8");
@mysqli_select_db($db, "trainer")
	or die ("Datenbankzugriff fehlgeschlagen!");

?>