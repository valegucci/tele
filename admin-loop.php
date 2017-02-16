<?php
require_once (dirname(__FILE__).'/functions.php');

$integrated = $size = $country = $feature = $s = '';
if(isset($_GET['size'])){
	$size = r4me_param_encode($_GET['size']);
	if($size !== 'global' && $size !== 'regional' && $size !== 'local'){
		$size = '';
	}
}
if(isset($_GET['is_integrated'])){
	$integrated = $_GET['is_integrated'];
	if($integrated !== '1'){
		$integrated = '';
	}
}

if(isset($_GET['country'])){
	$countries = r4me_get_countries();
	$country = strtoupper($_GET['country']);
	if(!r4me_search_array($country, $countries)){
		$country = '';
	}
}

if(isset($_GET['feature'])){
	$features = r4me_get_features();
	$feature = $_GET['feature'];
	if(!r4me_search_array($feature, $features)){
		$feature = '';
	}
}

if(isset($_GET['s'])){
	$s = r4me_param_encode($_GET['s']);
}

$page = 1;
if(isset($_GET['page']) && is_numeric($_GET['page'])){
	$page = $_GET['page'];

}


$args = array(
	'size' => $size,
	'feature' => $feature,
	'is_integrated' => $integrated,
	'search' => $s,
	'country' => $country,
	'feature' => $feature,
	'page' => $page,
	'vendors_per_page' => VENDORS_PER_PAGE
	);



$query = new R4Me_Query($args);

if($query->has_vendors()):
while($row = $query->get_vendors()): 
if(!empty($country) && !r4me_is_selected_country($country, r4me_get_vendor_country($row['id']))) continue;
if(!empty($feature) && !r4me_is_selected_feature($feature, r4me_get_vendor_feature($row['id']))) continue;	
$is_integrated = $row['is_integrated'];	
	?>

<div class="vendor col-xs-12 col-sm-4 col-md-3">
	<a href="<?php echo r4me_get_directory_url() . '/vendor/' . $row['slug']; ?>" class="company" data-id="<?php echo $row['id']; ?>" data-slug="<?php echo $row['slug']; ?>">
		<div class="logo">	
			<img src="<?php echo $row['logo_url']; ?>"/>
		</div>
		<div class="title">	
			<?php echo $row['name']; ?>
		</div>
		<?php if($is_integrated === '1'): ?>
			<div class="vendor-integrated"><div class="badge">Integrated</div></div>
		<?php endif; ?>
		<div class="vendor-edit">
			<a class="r4me-vendor-delete btn btn-danger" data-id="<?php echo $row['id']; ?>">Delete</a>
			<a class="btn btn-default" href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>
		</div>
	</a>
</div>
<?php endwhile; ?>
<?php else: ?>
	<div class="error">No results found! </div>
<?php endif; ?>
