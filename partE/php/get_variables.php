<?php

/* $_GET VALIDATION AND SUBMIT
----------------------------------------------------------------------------------------------------*/
/* If form is submmited, call function form_validation. If all data is correct, redirect to the 
results page to display the search results.  */

if(isset($_GET['wine_name']))
{
 	// Validates the submitted data on the server side
	$check = form_validation($_GET['wine_name'], $_GET['winery_name'], $_GET['region'], $_GET['variety'], 
		$_GET['wines_stock'], $_GET['wines_ordered'], $_GET['min_year'], $_GET['max_year'], 
		$_GET['min_price'], $_GET['max_price'] );

	if ($check) {
		header('Location: results.php?wine_name='.$_GET['wine_name'].'&winery_name='.$_GET['winery_name'].
			'&region='.$_GET['region'].'&variety='.$_GET['variety'].'&wines_stock='.$_GET['wines_stock'].
			'&wines_ordered='.$_GET['wines_ordered'].'&min_year='.$_GET['min_year'].
			'&max_year='.$_GET['max_year'].'&min_price='.$_GET['min_price'].'&max_price='.$_GET['max_price']);
	} 
	// else
	// {
	// 	retain_state();
	// }
}

?>