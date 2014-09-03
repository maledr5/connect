<?php
// echo $_GET['wine_name'];

require_once ("php/MiniTemplator.class.php");
require_once ('php/db.php');

$t = new MiniTemplator;

$t->readTemplateFromFile ("results_temp.htm");

// connection to database
try {
	$dsn = DB_ENGINE .':host=' . DB_HOST .';dbname=' . DB_NAME;
	$db = new PDO($dsn, DB_USER, DB_PW);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} 
catch (DBOException $exception) {
	echo $exception->getMessage();
	exit;
}

$search_result = get_results($db);
$colcount = $search_result->columnCount();

foreach ($search_result as $row) {

	for ($i = 0; $i < $colcount; $i++) 
	{
		if ($paint == 0) {
			$result = "<td class='row_alt2'> {$row[$i]} </td> " ;
		}
		else {
			$result = "<td class='row_alt'> {$row[$i]} </td> ";
		}
		
		$t->setVariable('result'.$i, $result);
	}	

	$t->addBlock("wines");

	if ($paint == 0) {
		$paint = 1;
	}
	else {
		$paint = 0;
	}

}

$t->generateOutput();

function get_results($connection) {

	// Constructing query - Joining tables
	
	$search_query = "SELECT DISTINCT wine.wine_name, grape_variety.variety, wine.year, 
	winery.winery_name, region.region_name, inventory.cost, inventory.on_hand, 
	SUM(items.qty), SUM(items.qty*items.price)
	FROM wine, grape_variety, wine_variety, winery, region, inventory, items
	WHERE wine.wine_id = wine_variety.wine_id
	AND wine_variety.variety_id = grape_variety.variety_id
	AND wine.winery_id = winery.winery_id
	AND winery.region_id = region.region_id
	AND wine.wine_id = inventory.wine_id
	AND wine.wine_id = items.wine_id";

	// values specified by the user - CONCATENATION, just added to query if the user input a value

	if ( isset($_GET["wine_name"]) && !(empty($_GET["wine_name"])) ) {
		$wine_name = $_GET["wine_name"];
		$search_query .= " AND wine.wine_name LIKE '%{$wine_name}%' ";
	}
	if ( isset($_GET["winery_name"]) && !(empty($_GET["winery_name"])) ) {
		$winery_name = $_GET["winery_name"];
		$search_query .= " AND winery.winery_name LIKE '%{$winery_name}%'";
	}
	if ( isset($_GET["region"]) && !(empty($_GET["region"])) && ($_GET["region"] != "All") ) {
		$region = $_GET["region"];
		$search_query .= " AND region.region_name = '{$region}'";
	}
	if ( isset($_GET["variety"]) && !(empty($_GET["variety"])) && ($_GET["variety"] != "All")) {
		$variety = $_GET["variety"];
		$search_query .= " AND grape_variety.variety = '{$variety}'";
	}
	if ( isset($_GET["wines_stock"]) && !(empty($_GET["wines_stock"])) ) {
		$wines_stock = $_GET["wines_stock"];
		$search_query .= " AND inventory.on_hand >= {$wines_stock}";
	}

	// if ( isset($_GET["wines_ordered"]) && !(empty($_GET["wines_ordered"])) ) {
	// 	$wines_ordered = $_GET["wines_ordered"];
	// 	$search_query .= " HAVING SUM(items.qty) >= {$wines_ordered}";
	// }

	$min_year = $_GET["min_year"];
	$max_year = $_GET["max_year"];

	$search_query .= " AND wine.year >= {$min_year}
	AND wine.year <= {$max_year}";
	
	if ( isset($_GET["min_price"]) && !(empty($_GET["min_price"])) ) {
		$min_price = $_GET["min_price"];
		$search_query .= " AND inventory.cost >= {$min_price}";
	}

	if ( isset($_GET["max_price"]) && !(empty($_GET["max_price"])) ) {
		$max_price = $_GET["max_price"];
		$search_query .= " AND inventory.cost <= {$max_price}";
	}

	$search_query .= " GROUP BY items.wine_id 
	ORDER BY wine.wine_name";

	$search_result = $connection->query($search_query); 

	return $search_result;

}

?>
