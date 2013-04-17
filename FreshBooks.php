<?php

error_reporting( E_ALL ^ ( E_NOTICE | E_WARNING ) );	


class FreshBooks {

	function FreshBooks( $options ) {

		$this->force_no_decode = false;	
		$this->debug = false;	


		if( $options != null ) foreach($options as $key => $value) $this->$key = $value; 
		
		$auth = array();

	}

	function log( $logthis ) {
		if( $this->debug ) {
			echo $logthis."\n";
		} else {
			@file_put_contents("/var/log/freshbooks.log",date("Y-m-d H:i:s")." - ".$logthis."\n",FILE_APPEND);
		}
	}




	function invoice_list( $filter = array('status' => 'draft') ) {
		foreach( $filter as $key => $val ) { $str_filter .= "<$key>$val</$key>"; }
		$data = '<?xml version="1.0" encoding="utf-8"?><request method="invoice.list">'.$str_filter.'</request>';
		$out = $this->send($data);
		return($out['invoices']['invoice']);	
	}


	function recurring_list( $filter ) {
		foreach( $filter as $key => $val ) { $str_filter .= "<$key>$val</$key>"; }
		$data = '<?xml version="1.0" encoding="utf-8"?><request method="recurring.list">'.$str_filter.'</request>';
		$out = $this->send($data);
		return($out);	
	}



	function request( $method, $filter ) {
		foreach( $filter as $key => $val ) { $str_filter .= "<$key>$val</$key>"; }
		$data = '<?xml version="1.0" encoding="utf-8"?><request method="'.$method.'">'.$str_filter.'</request>';
		$out = $this->send($data);
		return($out);	
	}
	function array_to_xml($arr) {
		$xml_out = '';
		foreach($arr as $key => $value ) { $xml_out .= "<$key>$value</$key>\n"; }
		return($xml_out);
	}



	function send( $data ) {

		$curlopt = array(
			CURLOPT_URL => $this->url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_VERBOSE => false,
			CURLOPT_USERPWD => $this->userpw,
			CURLOPT_POST => 1,
			CURLOPT_POSTFIELDS => $data,
			CURLOPT_INFILESIZE => strlen($data)
		);

		$curl = curl_init();
		curl_setopt_array($curl,$curlopt);
		$out_data = curl_exec($curl);
		if( curl_errno($curl) ) { $error_message = curl_error($curl); echo $error_message; }



		$xml_data = simplexml_load_string($out_data);
		$hash_data = $this->objectsIntoArray($xml_data);
		
		return($hash_data);


	}



	function objectsIntoArray($arrObjData, $arrSkipIndices = array()) {
	    $arrData = array();
	    
	    // if input is object, convert into array
	    if (is_object($arrObjData)) {
		$arrObjData = get_object_vars($arrObjData);
	    }
	    
	    if (is_array($arrObjData)) {
		foreach ($arrObjData as $index => $value) {
		    if (is_object($value) || is_array($value)) {
			$value = $this->objectsIntoArray($value, $arrSkipIndices); // recursive call
		    }
		    if (in_array($index, $arrSkipIndices)) {
			continue;
		    }
		    $arrData[$index] = $value;
		}
	    }
	    return $arrData;
	}





}



?>
