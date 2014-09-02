<?php
// echo $_GET['wine_name'];
include("connect.php");
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>The Wine Search</title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="css/general.css">
		<link rel="stylesheet" type="text/css" href="css/fonts.css">

	</head>

	<body>
		<!-- Background images and texture -->
		<div class="main_box">

			<div class="title2">RESULTS <br> _________________ </div>

			<table style="margin-top: 20px; padding-bottom: 100px;">
				<tr> 
					<td class="results_header">ID</td>
					<td class="results_header">Wine</td>
					<td class="results_header">Variety</td>
					<td class="results_header">Year</td>
					<td class="long_results_header">Winery</td>
					<td class="long_results_header">Region</td>
					<td class="results_header">Cost</td>
					<td class="results_header">Available</td>
					<td class="results_header">Sold</td>
					<td class="results_header">Revenue</td>
				</tr>

				<?php

				// To alternate row color
				$paint = 0;

				// while there are more rows
				while ($row = @ mysql_fetch_row($search_result)) 
				{
					// Condition to alternate row color
					if ($paint == 0) {
						echo " \n <tr>";
						$paint = 1;
					}
					else {
						echo " \n <tr class='row_alt'>";
						$paint = 0;
					}
					// for each column in the current row
					for ($i = 0; $i < mysql_num_fields($search_result); $i++) 
					{
						echo "  \n\t <td> {$row[$i]} </td> " ;
					}	

					echo "\n </tr>";
				}				
				
				mysql_close($connection);
				
				?>
			</table>

	</body>


</html>