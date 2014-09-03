<?php

/* FORM VALIDATION - SERVER SIDE
----------------------------------------------------------------------------------------------------*/
/* Server side will validate empty fields, numeric input and the year and cost range.  
Not need to validate require fields, because any of them is required. 
Also will refine strings using trim(), stripslashes() and htmlspecialchars() functions.*/

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