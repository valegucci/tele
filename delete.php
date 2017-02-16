<?php 

require_once (dirname(__FILE__).'/functions.php');

if(!r4me_user_logged_in()) die();


$message = '';

if(isset($_POST['vendor_id']) && ctype_digit($_POST['vendor_id'])):

	$id = $_POST['vendor_id'];

	$args = array(
	'id' => $id
	);

	$query = new R4ME_Query($args);

	if($query->has_vendors()):
		while($row = $query->get_vendors()):
		$target_dir = "logos/";
        $logo = basename($row['logo_url']);
        if(file_exists($target_dir . $logo)) unlink($target_dir . $logo);
     
    endwhile; 
    else:
    	die("Vendor couldn't be retrieved!");
    endif; 

	r4me_delete_feature_relations($id);
	r4me_delete_country_relations($id);

	$delete = new R4Me_Query($args, "DELETE");

	if($delete):
		$message = 'Vendor successfully deleted.';
	else:
		$message = 'Error Deleting the vendor!';
	endif;

	echo $message;

endif;

die();