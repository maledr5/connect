<?php
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
<!-- 			<div class="background_img"></div>
 -->
			<div class="title2">RESULTS <br> _________________ </div>

			<?php
			//echo $_GET['wine_name'];
			//echo $wine_name;


			while ($row = mysql_fetch_row($search_result)) // while there are more rows
			{
				for ($i = 0; $i < mysql_num_fields($search_result); $i++) // for each column in the current row
				{
					echo $row[$i] . " ";
				}	
				echo "\n";
			}				
			
			mysql_close($connection);
			
			?>


	</body>


</html>