<?php

/* FORM VALIDATION - SERVER SIDE
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
}

/* FORM VALIDATION - SERVER SIDE
----------------------------------------------------------------------------------------------------*/
/* Server side will validate empty fields, numeric input and the year and cost range.  
Not need to validate require fields, because any of them is required. 
Also will refine strings using trim(), stripslashes() and htmlspecialchars() functions.*/

function form_validation($wine_name, $winery_name, $region, $variety, $stock, $ordered, $year_from, 
	$year_to, $range_min, $range_max) 
{

	// Variables for error messages
	global $msg1, $msg2, $msg3, $msg4, $msg5, $msg6;
	$val6 = false;

	// numeric validation
	$val1 = check_number($stock);
	if (!$val1)
		$msg1 = "This field must be a number.";

	$val2 = check_number($ordered);
	if (!$val2)
		$msg2 = "This field must be a number.";

	$val3 = check_number($range_min);
	if (!$val3)
		$msg3 = "This field must be a number.";

	$val4 = check_number($range_max);
	if (!$val4)
		$msg4 = "This field must be a number.";

	// Validates the correct year range (From can not be greater than To)
	$val5 = year_range($year_from, $year_to);
	if (!$val5)
		$msg5 = "'To' field should be greater than 'From'";

	// Validates the correct year range (Min can not be greater than Max)
	if ($val3 && $val4)
	{
		$val6 = cost_range($range_min, $range_max);
		if (!$val6)
			$msg6 = "'Min' can't be greater than 'Max'";
	}

	// If any error exists, don't go on
	if ($val1 && $val2 && $val3 && $val4 && $val5 && $val6)
	{
		return true;
	}
	else 
	{
		return false;
	}
}

function refine_input($input)
{
     $input = trim($input);
     $input = stripslashes($input);
     $input = htmlspecialchars($input);
     return $input;
}

// Checks for a numeric input
function check_number($number)
{
	$number = refine_input($number);

	if (!preg_match("/^[0-9]*$/",$number))
	{
		return false;
	}
	else
	{
		return true;
	}
}

// Checks for the correct year range
function year_range($y_from, $y_to)
{ 
	$y_from = refine_input($y_from);
	$y_to = refine_input($y_to);

	if ($y_to < $y_from) 
	{
		return false;
	}
	else
	{
		return true;
	}
	
}

// Checks for the correct cost range
function cost_range($range_min, $range_max)
{ 
	$range_min = refine_input($y_from);
	$range_max = refine_input($y_to);

	if ($range_max < $range_min) 
	{
		return false;
	}
	else
	{
		return true;
	}
}




?>