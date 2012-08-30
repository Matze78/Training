<!-- PHP Setup-Skript -->

<?php

$db = mysqli_connect('localhost','root','') or die ("Zugriff fehlgeschlagen");
mysqli_set_charset($db, "utf8"); // uft8 ohne Bindestrich
mysqli_select_db($db, 'trainer') or die ("Zugriff gescheitert");

$sql1 = "CREATE TABLE topics (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, Thema VARCHAR(40)) DEFAULT CHARACTER SET utf8";


mysqli_query($db, $sql1)



?>