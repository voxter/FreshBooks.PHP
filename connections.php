<?php
	global $CONNECTIONS;


	$conn_fname = "connections.php";

	$home_dir = getenv("HOME");

	//Check for a local connections.php file
	if( file_exists("$home_dir/$conn_fname") ) {
		include("$home_dir/$conn_fname"); 
	} else {

		$CONNECTIONS['main']['url'] = "https://main.freshbooks.com/api/2.1/xml-in";
		$CONNECTIONS['main']['userpw'] = 'YouAPIKey:X';

		$company_name = "";
		$CONNECTIONS[$company_name]['url'] = "https://$company_name.freshbooks.com/api/2.1/xml-in";
		$CONNECTIONS[$company_name]['userpw'] = 'YouAPIKey:X';

		$company_name = "";
		$CONNECTIONS[$company_name]['url'] = "https://$company_name.freshbooks.com/api/2.1/xml-in";
		$CONNECTIONS[$company_name]['userpw'] = 'YourAPIKey:X';

		$company_name = "";
		$CONNECTIONS[$company_name]['url'] = "https://$company_name.freshbooks.com/api/2.1/xml-in";
		$CONNECTIONS[$company_name]['userpw'] = 'YourAPIKey:X';

		$company_name = "";
		$CONNECTIONS[$company_name]['url'] = "https://$company_name.freshbooks.com/api/2.1/xml-in";
		$CONNECTIONS[$company_name]['userpw'] = 'YourAPIKey:X';

		$company_name = "";
		$CONNECTIONS[$company_name]['url'] = "https://$company_name.freshbooks.com/api/2.1/xml-in";
		$CONNECTIONS[$company_name]['userpw'] = 'YourAPIKey:X';
	}

?>
