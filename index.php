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
			<div class="background_img"></div>

			<div class="title1">SEARCH <br> _________________ </div>

			<div class="form">
				<form name="search_database" action="results.php" method="GET" onsubmit="return form_validation();">
					<table>

						<!-- Wine name -->
						<tr>
							<td class="right">Wine Name</td>
							<td class="left"><input type="text" name="wine_name" id="form1" value=""></td>
							<td><span id="validation1"><?php echo $fname_msg;?></span></td> <!-- error message -->
						</tr>

						<!-- Winery name -->
						<tr>
							<td class="right">Winery Name</td>
							<td class="left"><input type="text" name="winery_name" id="form2" value=""></td>
							<td><span id="validation2"><?php echo $lname_msg;?> </span></td> <!-- error message -->
						</tr>

						<!-- Region name -->
						<tr>
							<td class="right">Region</td>
							<td class="left">
								<select name="region" id="form10" >
									<?php 
										display_query($region_result);
									?>
								</select>
							</td>
							<td><span id="validation7"><?php global $expiry_msg; echo $expiry_msg;?></span></td> <!-- error message -->
						</tr>

						<!-- Grape variety -->
						<tr>
							<td class="right">Grape Variety</td>
							<td class="left">
								<select name="variety" id="form10" >
									<?php 
										display_query($vaiety_result);
									?>
								</select>
							</td>
							<td><span id="validation7"><?php global $expiry_msg; echo $expiry_msg;?></span></td> <!-- error message -->
						</tr>

						<!-- Wine Stock -->
						<tr>
							<td class="right">Wines in stock</td>
							<td class="left"><input type="text" name="wines_stock" id="form2" value=""></td>
							<td><span id="validation2"><?php echo $lname_msg;?> </span></td> <!-- error message -->
						</tr>

						<!-- Wines ordered -->
						<tr>
							<td class="right">Wines ordered</td>
							<td class="left"><input type="text" name="wines_ordered" id="form2" value=""></td>
							<td><span id="validation2"><?php echo $lname_msg;?> </span></td> <!-- error message -->
						</tr>

						<!-- Year range -->
						<tr>
							<td class="right" style="padding: 5px 0px;">Year Range</td>
						</tr>
						<tr>	
							<td class="right" style="color: #99CCCC;"> From </td>
							<td class="left">	
								<select name="min_year" id="form10" >
									<?php 
										display_query($min_year_result);
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td class="right" style="color: #99CCCC;"> To </td>
							<td class="left">	
								<select name="max_year" id="form10" >
									<?php 
										display_query($max_year_result);
									?>
								</select>
							</td>
							<td><span id="validation7"><?php global $expiry_msg; echo $expiry_msg;?></span></td> <!-- error message -->
						</tr>

						<!-- Cost Range -->
						<tr>
							<td class="right" style="padding: 5px 0px;">Cost Range</td>
						</tr>
						<tr>
							<td class="right" style="color: #99CCCC;" >Min</td>
							<td class="left"><input type="text" name="min_price" id="form1" value=""></td>
							<td><span id="validation1"><?php echo $fname_msg;?></span></td> <!-- error message -->
						</tr>
						<tr>
							<td class="right" style="color: #99CCCC;">Max</td>
							<td class="left"><input type="text" name="max_price" id="form1" value=""></td>
							<td><span id="validation1"><?php echo $fname_msg;?></span></td> <!-- error message -->
						</tr>
					</table> 
					<input type="submit" name="search" value="Search" id="cart_butt" class="search_but">					
				</form>
			</div>
		</div>	

	</body>


</html>

