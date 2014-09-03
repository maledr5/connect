<?php
	session_start();
	include 'config_twitter.php';

	$views = array();

	if (isset($_SESSION["history"])){
		$views = $_SESSION["history"];
	}

	$views = array_unique($views);

	function myfunction($v1,$v2){
		return $v1 . " " . $v2;
	}

	$post = array_reduce($views, "myfunction");

	$shortPost = (strlen($post) > 140) ? substr($post,0,140) : $post;

	// Post the twitter status update using the short wines_viewed list
	$parameters = array('status' => $shortPost);
	$status = $connection->post('statuses/update', $parameters);

	// Returns the user back to search page
	header('location:../index.php');

?>