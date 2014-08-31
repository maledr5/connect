<?php
	
	// Turn off all error reporting
   error_reporting(0);

	require_once('db.php');

	// connection to database
	$connection = mysql_connect(DB_HOST, DB_USER, DB_PW);
	mysql_select_db("winestore", $connection);



/* DATABASE-DRIVEN QUERY 
----------------------------------------------------------------------------------------------------*/
/* Populate the search form -*/
	
	// region query
	$region_query = "SELECT region_name FROM region";
	$region_result = mysql_query($region_query, $connection);

	// variety query
	$vaiety_query = "SELECT variety FROM grape_variety";
	$vaiety_result = mysql_query($vaiety_query, $connection);

	// years query
	$min_year_query = "SELECT distinct(year) FROM wine ORDER BY year asc";
	$min_year_result = mysql_query($min_year_query, $connection);

	$max_year_query = "SELECT distinct(year) FROM wine ORDER BY year desc";
	$max_year_result = mysql_query($max_year_query, $connection);

	// function to display results in the form
	function display_query($result)
	{
		while ($row = mysql_fetch_row($result)) // while there are more rows
		{
			for ($i = 0; $i < mysql_num_fields($result); $i++) // for each column in the current row
			{
				echo "<option value='{$row[$i]}'> {$row[$i]} </option>";
			}	
		}
	}

/* USER-DRIVEN QUERY 
----------------------------------------------------------------------------------------------------*/
/* Return search results -*/

	// assign variables for queries

	if (isset($_GET["wine_name"]))
	{
		$wine_name = $_GET["wine_name"];
	} 
	
	if (isset($_GET["winery_name"]))
	{
		$winery_name = $_GET["winery_name"];
	} 
	
	$search_query = "SELECT DISTINCT wine.wine_id, wine.wine_name, grape_variety.variety, wine.year, winery.winery_name, 
							region.region_name, inventory.cost, inventory.on_hand, SUM(items.qty), SUM(items.qty*items.price)
					 FROM wine, grape_variety, wine_variety, winery, region, inventory, items
					 WHERE wine.wine_id = wine_variety.wine_id
					 AND wine_variety.variety_id = grape_variety.variety_id
					 AND wine.winery_id = winery.winery_id
					 AND winery.region_id = region.region_id
					 AND wine.wine_id = inventory.wine_id
					 AND wine.wine_id = items.wine_id
					 AND wine.wine_name = '{$wine_name}' 
					 GROUP BY items.wine_id ";
					 
					 
	$search_result = mysql_query($search_query, $connection);



?>