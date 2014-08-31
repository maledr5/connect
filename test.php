<!DOCTYPE HTML>
<html>
	<head>
		<title>The Wine Search</title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="css/general.css">
		<link rel="stylesheet" type="text/css" href="css/fonts.css">

	</head>

	<body>

		<?php

		require_once('db.php');

		// connection to database
		$connection = mysql_connect(DB_HOST, DB_USER, DB_PW);
		mysql_select_db("winestore", $connection);

		// run query
		$query = "SELECT distinct(year) FROM wine WHERE year <= ALL (SELECT year FROM wine)";
		$result = mysql_query($query, $connection);

		// $result = "SELECT year FROM wine WHERE year <= (SELECT year FROM wine)";
		// $result = mysql_query($result, $connection);


		// display results
		echo "<pre>\n";

		while ($row = mysql_fetch_row($result)) // while there are more rows
		{
			for ($i = 0; $i < mysql_num_fields($result); $i++) // for each column in the current row
			{
				echo $row[$i] . " ";
			}	
			echo "\n";
		}	

		echo "</pre>";

		mysql_close($connection);

		/* min year:
		year query
		$min_year_query = "SELECT distinct(year) FROM wine WHERE year <= ALL (SELECT year FROM wine)";
		$min_year_result = mysql_query($min_year_query, $connection);
		*/

		?>

	</body>
	</head>
</html>




