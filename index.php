<?php
 
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	require "Config/autoload.php";
	require "Config/config.php";

	use Config\autoload as Autoload;
	use Config\router 	as Router;
	use Config\request 	as Request;
		
	Autoload::start();

	session_start();

	require_once(VIEWS_PATH."header.php");

	Router::Route(new Request());

	require_once(VIEWS_PATH."footer.php");
?>

