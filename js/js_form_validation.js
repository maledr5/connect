/* FORM VALIDATION - CLIENT SIDE
----------------------------------------------------------------------------------------------------*/
/* Client side will validate numeric input and the year and cost range.  Not need to validate 
require fields, because any of them is required */

function form_validation() {
	// Define variables
	var stock, ordered, year_from, year_to, range_min, range_max;
	var val1, val2, val3, val4, val5;
	var val6 = false;

	stock = document.getElementById("form5").value;
	ordered = document.getElementById("form6").value;
	year_from = document.getElementById("form7").value;
	year_to = document.getElementById("form8").value;
	range_min = document.getElementById("form9").value;
	range_max = document.getElementById("form10").value;

	// numeric validation
	val1 = check_number(stock, "validation1");
	val2 = check_number(ordered, "validation2");

	// Validates the correct year range (From can not be greater than To)
	val3 = year_range(year_from, year_to, "validation3");

	// Validates the correct year range (Min can not be greater than Max)
	val4 = check_number(range_min, "validation4");
	val5 = check_number(range_max, "validation5");
	if (val4 && val5) 
	{
		val6 = cost_range(range_min, range_max, "validation6");
	}
	
	// If any error exists, don't go on
	if (val1 && val2 && val3 && val4 && val5 && val6)
	{
		return true;
	}
	else 
	{
		return false;
	}
}

// Checks for a numeric input
function check_number(number, error_id)
{ 
	var regex = /^[0-9 ]*$/;

	if (number == null || number == "" || number.match(/^s+$/) || number.match(regex))
	{
		document.getElementById(error_id).innerHTML = " ";
		return true;
	}
	else 
	{
		document.getElementById(error_id).innerHTML = "This field must be a number.";
		return false;
	} 
}

// Checks for the correct year range
function year_range(y_from, y_to, error_id)
{ 
	if (y_to < y_from) 
	{
		document.getElementById(error_id).innerHTML = "'To' field should be greater than 'From'";
		return false;
	}
	else
	{
		document.getElementById(error_id).innerHTML = " ";
		return true;
	}
}

// Checks for the correct cost range
function cost_range(range_min, range_max, error_id)
{ 
	if (range_max < range_min) 
	{
		document.getElementById(error_id).innerHTML = "'Min' can't be greater than 'Max'";
		return false;
	}
	else
	{
		document.getElementById(error_id).innerHTML = " ";
		return true;
	}
}
