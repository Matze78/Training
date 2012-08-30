<!DOCTYPE html>
<html>
<body>

<form name="test1" action="">
<select name="cars">
<option value="volvo">Volvo</option>
<option value="saab">Saab</option>
<option selected value="fiat">Fiat</option>
<option value="audi">Audi</option>
</select>
</form>


<?php

include("zugriff.inc.php");
$sql = "SELECT * FROM topics";
$result = mysqli_query($db, $sql);
// $row = mysqli_fetch_assoc($result);



echo "<form name='test2' action=''>";
echo "<select name='topics'>";
while ($row = mysqli_fetch_assoc($result)){
echo "<option value='". $row['id'] ."'>". $row['Thema'] ."</option>";
}
echo "</select></form>";

?>
</body>
</html>