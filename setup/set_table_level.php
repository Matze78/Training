<!-- PHP Setup-Skript -->

<?php

$db = mysqli_connect('localhost','root','') or die ("Zugriff fehlgeschlagen");
mysqli_set_charset($db, "utf8"); // uft8 ohne Bindestrich
mysqli_select_db($db, 'trainer') or die ("Zugriff gescheitert");

$sql1 = "CREATE TABLE levels (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, Level VARCHAR(14)) DEFAULT CHARACTER SET utf8";

mysqli_query($db, $sql1);

$sql2= "INSERT INTO  `trainer`.`levels` (`id` ,`Level`) VALUES ('' ,  'normal');";
mysqli_query($db, $sql2);

$sql3= "INSERT INTO  `trainer`.`levels` (`id` ,`Level`) VALUES ('' ,  'anspruchsvoll');";
mysqli_query($db, $sql3);

$sql4= "INSERT INTO  `trainer`.`levels` (`id` ,`Level`) VALUES ('' ,  'schwer');";
mysqli_query($db, $sql4);

?>