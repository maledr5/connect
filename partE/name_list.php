<?php
session_start();

$history = $_SESSION['history'];

echo "<div class='title2'>RESULTS <br> _________________ </div>";
echo "</br>";

foreach($history as $name)
{
	echo $name . "</br>";
}


?>
