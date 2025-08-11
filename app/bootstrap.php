<?php 
	
	// Load config files
	require_once 'config/config.php';

	//Load Libraries
#	require_once 'libraries/Controller.php';
#	require_once 'libraries/Core.php';
#	require_once 'libraries/Database.php';
	
	//load helper funtions for redirect
	require_once 'helpers/url_helper.php';
	require_once 'helpers/session_helper.php';

	// Auload Core Libraries

	spl_autoload_register(
		
		function($className){
			require_once 'libraries/'.$className.'.php';
		}
	);
?>