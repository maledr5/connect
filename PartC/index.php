<?php

require_once ("php/MiniTemplator.class.php");
require_once ('php/db.php');

$t = new MiniTemplator;

$t->readTemplateFromFile ("index_temp.htm");

db_driven_query(); 
$t->generateOutput();

function db_driven_query() {

	global $t;

	// connection to database
	$connection = mysqli_connect(DB_HOST, DB_USER, DB_PW, DB_NAME);

    // region query
	$region_result = mysqli_query($connection,"SELECT region_name FROM region");
    while($row = mysqli_fetch_array($region_result)) 
    {
        $t->setVariable ("region", $row['region_name']);   
        $t->addBlock ("region_block");
    }

	// variety query
    $vaiety_result = mysqli_query($connection,"SELECT variety FROM grape_variety");
    while($row = mysqli_fetch_array($vaiety_result)) 
    {
        $t->setVariable ("variety", $row['variety']);   
        $t->addBlock ("variety_block");
    }

   // years query
    $min_year_result = mysqli_query($connection,"SELECT distinct(year) FROM wine ORDER BY year asc");
    while($row = mysqli_fetch_array($min_year_result)) 
    {
        $t->setVariable ("min_year", $row['year']);   
        $t->addBlock ("min_year_block");
    }

    $max_year_result = mysqli_query($connection,"SELECT distinct(year) FROM wine ORDER BY year desc");
    while($row = mysqli_fetch_array($max_year_result)) 
    {
        $t->setVariable ("max_year", $row['year']);   
        $t->addBlock ("max_year_block");
    }

}

?>

