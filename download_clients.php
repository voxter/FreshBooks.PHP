#!/usr/bin/php
<?php

	global $CONNECTIONS;

	include("FreshBooks.php");
	$conn_fname = "connections.php";

	$home_dir = getenv("HOME");

	if( file_exists("$home_dir/$conn_fname") ) {
		include("$home_dir/$conn_fname"); 
	} else {
		include("$conn_fname");
	}

	print_r($CONNECTIONS);

	if( !isset($argv[1]) ) {
		echo "Usage: {$argv[0]} (connection) <email>\n";
		exit(0);
	}

	$fb = new FreshBooks( $CONNECTIONS[$argv[1]] );

	$rec_filter = array( 'per_page' => '100' );


	$rec_list  = $fb->request('client.list', array( 'per_page' => '100' ) );
	//$rec_list = $fb->request('client.list', array('email'=>$argv[2]));

	$total_pages = $rec_list['clients']['@attributes']['pages'];
	for( $page = 1; $page < $total_pages+1; $page++ ) {

		if( $page > 1 ) { $rec_filter['page'] = $page; $rec_list = $fb->request('client.list',$rec_filter); }

		foreach( $rec_list['clients']['client'] as $client ) {
			if( !isset($argv[2]) ) {
				echo $client['client_id']."|".$client['email']."|".$client['organization']."\n";
			} else if( $client['email'] == $argv[2] ) {
				echo $client['client_id']."|".$client['email']."|".$client['organization']."\n";

			}
		}
	}






?>
