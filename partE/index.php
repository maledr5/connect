<?php

/* SESSIONS
----------------------------------------------------------------------------------------------------*/

// Starting the session

if (isset($_GET["start_session"])){
  $sessionStatus = $_GET["start_session"];

  if ($sessionStatus == 'StartSession') {
    session_start();
    $_SESSION['history'] = array();
  }
}

// if (isset($_SESSION['history'])) {
//       session_start();
// }

/* TEMPLATE
----------------------------------------------------------------------------------------------------*/
require_once ("php/MiniTemplator.class.php");

$t = new MiniTemplator;

$t->readTemplateFromFile ("index_temp.htm");



db_driven_query();

function db_driven_query() {

  require_once ('php/db.php');

  global $t;

	//connection to database
  try {
    $dsn = DB_ENGINE .':host='. DB_HOST .';dbname='. DB_NAME;
    $db = new PDO($dsn, DB_USER, DB_PW);
  } 
  catch (DBOException $exception) {
   echo $exception->getMessage();
   exit; 
 }

    // region query
 $region_query = "SELECT region_name FROM region";
 foreach($db->query($region_query) as $row) 
 {
  $t->setVariable ("region", $row['region_name']); 
  $t->addBlock ("region_block"); 
}

    	// variety query
$vaiety_query = "SELECT variety FROM grape_variety";
foreach($db->query($vaiety_query) as $row) {
  $t->setVariable ("variety", $row['variety']); 
  $t->addBlock ("variety_block"); 
}

       // years query
$min_year_query = "SELECT distinct(year) FROM wine ORDER BY year asc";
foreach($db->query($min_year_query) as $row) {
  $t->setVariable ("min_year", $row['year']); 
  $t->addBlock ("min_year_block"); 
}

$max_year_query = "SELECT distinct(year) FROM wine ORDER BY year desc";
foreach($db->query($max_year_query) as $row) {
  $t->setVariable ("max_year", $row['year']); 
  $t->addBlock ("max_year_block"); 
}

}

// /* DEBUG
// ----------------------------------------------------------------------------------------------------*/
  // $ses = print_r ($_SESSION, true);
  // $get = print_r ($_GET, true);

  // $t->setVariable ("debg1", "test text");
  //   $t->addBlock ("debug"); 
  
  // if (isset($_SESSION['history'])){
  //    $t->setVariable ("debg1", "is set");
  //   $t->addBlock ("debug");
  // }

  // $t->setVariable ("debg1", $ses);
  // $t->addBlock ("debug"); 

  // $t->setVariable ("debg1", $get);
  // $t->addBlock ("debug");


  /* GENERATE TEMPLATE
  ----------------------------------------------------------------------------------------------------*/

  $t->generateOutput();

  ?>

