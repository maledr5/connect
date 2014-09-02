<?php
include("php/form_validation.php");
include("connect.php");
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>The Wine Search</title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="css/general.css">
		<link rel="stylesheet" type="text/css" href="css/fonts.css">
		<script src="js/js_form_validation.js"></script>
	</head>

	<body>
		<!-- Form -->
		<div class="main_box">
			<div class="background_img"></div>

			<div class="title1">SEARCH <br> _________________ </div>

			<div class="form">
				<form name="search_database" action="" method="GET" onsubmit="return form_validation();">

					<table class"form_table" >
						<!-- Wine name -->
						<tr>
							<td class="right">Wine Name</td>
							<td class="left"><input type="text" name="wine_name" id="form1" value="<?php echo $_GET['wine_name'] ?>"></td>
						</tr>

						<!-- Winery name -->
						<tr>
							<td class="right">Winery Name</td>
							<td class="left"><input type="text" name="winery_name" id="form2" value="<?php echo $_GET['winery_name'] ?>"></td>
						</tr>

						<!-- Region name -->
						<tr>
							<td class="right">Region</td>
							<td class="left">
								<select name="region" id="form3" >
									<?php 
										display_query($region_result);
									?>
								</select>
							</td>
						</tr>

						<!-- Grape variety -->
						<tr>
							<td class="right">Grape Variety</td>
							<td class="left">
								<select name="variety" id="form4" >
									<option value=''> All </option>
									<?php 
										display_query($vaiety_result);
									?>
								</select>
							</td>
						</tr>

						<!-- Wine Stock -->
						<tr>
							<td class="right">Wines in stock</td>
							<td class="left"><input type="text" name="wines_stock" id="form5" value="<?php echo $_GET['wines_stock'] ?>"></td>
							<td class="error"><span id="validation1"><?php echo $msg1; ?></span></td> <!-- error message -->
						</tr>

						<!-- Wines ordered -->
						<tr>
							<td class="right">Wines ordered</td>
							<td class="left"><input type="text" name="wines_ordered" id="form6" value="<?php echo $_GET['wines_ordered'] ?>"></td>
							<td class="error"><span id="validation2"><?php echo $msg2; ?></span></td> <!-- error message -->
						</tr>

						<!-- Year range -->
						<tr>
							<td class="right" style="padding: 5px 0px;">Year Range</td>
							<td class="error"><span id="validation3"><?php echo $msg5; ?></span></td> <!-- error message -->
						</tr>
						<tr>	
							<td class="right" style="color: #99CCCC;"> From </td>
							<td class="left">	
								<select name="min_year" id="form7" >
									<?php 
										display_query($min_year_result);
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td class="right" style="color: #99CCCC;"> To </td>
							<td class="left">	
								<select name="max_year" id="form8" >
									<?php 
										display_query($max_year_result);
									?>
								</select>
							</td>
							
						</tr>

						<!-- Cost Range -->
						<tr>
							<td class="right" style="padding: 5px 0px;">Cost Range</td>
							<td class="error"><span id="validation6"><?php echo $msg6; ?></span></td> <!-- error message -->
						</tr>
						<tr>
							<td class="right" style="color: #99CCCC;" >Min</td>
							<td class="left"><input type="text" name="min_price" id="form9" value="<?php echo $_GET['min_price'] ?>"></td>
							<td class="error"><span id="validation4"><?php echo $msg3; ?></span></td> <!-- error message -->
						</tr>
						<tr>
							<td class="right" style="color: #99CCCC;">Max</td>
							<td class="left"><input type="text" name="max_price" id="form10" value="<?php echo $_GET['max_price'] ?>"></td>
							<td class="error"><span id="validation5"><?php echo $msg4; ?></span></td> <!-- error message -->
						</tr>
					</table> 
					<input type="submit" name="search" value="Search" id="search_butt" class="search_but">					
				</form>
			</div>
		</div>	

	</body>


</html>

