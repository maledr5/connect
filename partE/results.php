<?php
session_start();

if (isset($_GET['stop_session'])) {
	$sessionStatus = $_GET["stop_session"];
    
    if ($sessionStatus == 'endSession') {
    	unset($_SESSION['history']);
	    session_destroy();
	    header('Location:index.php');
	    die();
	}
}


/* TEMPLATE
----------------------------------------------------------------------------------------------------*/
require_once ("php/MiniTemplator.class.php");
require_once ('php/db.php');

$t = new MiniTemplator;

$t->readTemplateFromFile ("results_temp.htm");


// stop sessions button display if sessions are on
if (isset($_SESSION['history'])) {
    $button = "<input type='submit' value='Stop Sessions'>";
    $t->setVariable('butt1', $button);
    $t-> addBlock("stop_button");
}

// history button display if sessions are on
if (isset($_SESSION['history'])) {
    $button = "<input type='submit' value='See History'>";
    $t->setVariable('butt2', $button);
    $t-> addBlock("history_button");
}

	$button = "<input type='submit' value='Search Again'>";
    $t->setVariable('butt3', $button);
    $t-> addBlock("back_button");

	$button1 = "<input type='submit' value='Twitter'>";
    $t->setVariable('butt4', $button1);
    $t-> addBlock("twitter_button");

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
$save_names = $search_result ;
$colcount = $search_result->columnCount();
$paint = 0;



// Display results
foreach ($search_result as $row) {

	if (isset($_SESSION['history'])) {
	    array_push($_SESSION['history'], $row['wine_name']);
    }

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

// // Store name values
// if (isset($_SESSION['history'])) {
//     foreach ($save_names as $row) {
// 	    array_push($_SESSION['history'], $row['wine_name']);
//     }
// }

function get_results($connection) {

	// Constructing query - Joining tables
	
	$search_query = "SELECT DISTINCT wine.wine_name, grape_variety.variety, wine.year, 
	winery.winery_name, region.region_name, inventory.cost, inventory.on_hand, 
	SUM(items.qty), SUM(items.price)
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

// // /* DEBUG
// // ----------------------------------------------------------------------------------------------------*/
//   $ses = print_r ($_SESSION, true);
//   $get = print_r ($_GET, true);

// 	$t->setVariable ("debg1", "test text");
//   	$t->addBlock ("debug"); 
  
//   if (isset($_SESSION['history'])){
//   	 $t->setVariable ("debg1", "is set");
//   	$t->addBlock ("debug");
//   }

//   $t->setVariable ("debg1", $ses);
//   $t->addBlock ("debug"); 

//   $t->setVariable ("debg1", $get);
//   $t->addBlock ("debug");

 /* GENERATE TEMPLATE
----------------------------------------------------------------------------------------------------*/
  $t->generateOutput();

?>
