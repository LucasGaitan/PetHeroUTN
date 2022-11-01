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

	Router::Route(new Request());

?>

