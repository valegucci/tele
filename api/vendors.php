<?php 

require_once(dirname(dirname(__FILE__)).'/functions.php');
require_once(dirname(__FILE__).'/rest.php');

$errors = array();

if(isset($_GET['api_key'])):
	$api_key = $_GET['api_key'];
	$rest = new SimpleRest();

	if($rest->isValidKey($_GET['api_key'])):
	

		if(isset($_GET['vendor_id'])){
			$vendors = $rest->getVendor($_GET['vendor_id']);
		}else{
			$vendors = $rest->getVendors($_GET);
		}

		if(isset($vendors['vendors']) || isset($vendors['vendor'])){
			$rest->setHttpHeaders(200);
		}elseif(isset($vendors['errors'])){	
			$rest->setHttpHeaders(417);
		}else{
			$rest->setHttpHeaders(404);
			$errors['errors'][] = 'No data';
			echo json_encode($errors);
			die();
		}
	
	echo json_encode($vendors);
	die();
	else:
		$errors['errors'][] = 'Incorrect API key';
		echo json_encode($errors);
		die();
	endif;
else:
	$errors['errors'][] = 'API key not defined';
	echo json_encode($errors);
	die();
endif;

