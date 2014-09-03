<?php
	
	require_once 'twitteroauth.php';

	$consumer_key = "KNNINt1VFDkh5pSkP92B2JlAP";
	$consumer_secret = "69kEkZsF1eWzwFc4Dg3Jh6BBO3TWC9oi1UCrcfDaDzTW4jnG2A";
	$oauth_token = "2787881628-PxpJezUHklatJvdBsrxq4E97qyKBWOWpvnUsJgM";
	$oauth_token_secret = "Kp5wLNWoPcuKJNpizuuVH2UHorlzft0xZTPM5hphT8wvr";

	$connection = new TwitterOAuth($consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret);


?>