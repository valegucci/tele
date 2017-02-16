<?php

require_once (dirname(__FILE__).'/functions.php'); 

include_once('header.php');

if(isset($_GET['vendor'])){
	$vendor = r4me_param_encode($_GET['vendor']);

	$args = array('vendor' => $vendor);

	$query = new R4ME_Query($args);

	if($query->has_vendors()):
		while($row = $query->get_vendors()): 
			$countries = r4me_get_vendor_country($row['id']);
			$features = r4me_get_vendor_feature($row['id']);
			$is_integrated = $row['is_integrated'];
			?>

<div class="titlebar">
	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-xs-12">
				<ul class="breadcrumbs list-inline">
					<li><a href="<?php echo r4me_get_directory_url(); ?>">Telematics vendors</a></li> 
					<li>&raquo;</li>
					<li><?php echo htmlentities($row['name']); ?></li>
				</ul>
			</div>	
			<div class="col-sm-6 hidden-xs">
				<h1><?php echo htmlentities($row['name']); ?></h1>
			</div>	
		</div>
	</div>
</div>
<div class="pad20"></div>

<div class="single-vendor-container container">

			<div class="single-vendor">
				<div class="row">
				<div class="single-vendor-image col-sm-5">
					<img src="<?php echo $row['logo_url']; ?>" alt="<?php echo $row['name']; ?>"/>
				</div>
				<div class="single-vendor-features col-sm-7">
					<h3 class="single-vendor-title"><?php echo htmlentities($row['name']); ?></h3>

					<?php if(!empty($countries)): ?>
						<p><strong>Country:</strong> 
					<?php
						$cstring = '';
						foreach ($countries as $country) {
							$cstring .= '<a href="'.r4me_get_directory_url() . '?country=' . $country['code'].'">'.$country['name'].'</a>, ';
						}
						echo rtrim($cstring, ', ') . '</p>';
					endif; ?>

					<p><strong>Company Size:</strong> <?php echo $row['size']; ?></p>
					<?php if(!empty($features)): ?>
					<p><strong>Features:</strong> 
					<?php
						$fstring = '';
						foreach ($features as $feature) {
							$extra = '';
							if($feature['slug'] == 'android-driver' || $feature['slug'] == 'ios-driver'){
								$extra = ' (Driver)';
							}elseif($feature['slug'] == 'android-management' || $feature['slug'] == 'ios-management'){
								$extra = ' (Management)';
							}
							$fstring .= '<a href="'.r4me_get_directory_url() . '?feature=' . $feature['slug'].'">'.$feature['name'].$extra.'</a>, ';
						}
						echo rtrim($fstring, ', ') . '</p>';
					 endif;
					 ?>
					<p><strong>Integrated with Route4Me:</strong> <?php echo ($is_integrated === '1' ? 'Yes' : 'No'); ?></p>
					
					<?php 
					$links = '';
					if(trim($row['website_url']) !== ''): 
						$links .= '<a href="'. htmlentities($row['website_url']) .'" target="_blank" data-toggle="tooltip" data-placement="top" title="Vendor Website">Website</a>, ';
					endif;
					if(trim($row['api_docs_url']) !== ''):
					$links .= '<a href="'. htmlentities($row['api_docs_url']) .'" target="_blank" data-toggle="tooltip" data-placement="top" title="Vendor API Documentation">API Documentation</a>';
					endif; 
					if($links !== ''):
						echo '<p><strong>Links:</strong> ' . rtrim($links, ', ') . '</p>';
					endif;
					?>
				</div>

			</div>
			<div class="pad10"></div>
				<div class="single-vendor-desc">
					<?php echo r4me_format_text($row['description']); ?>
				</div>
				<div class="pad20"></div>
				<a class="btn btn-default" href="<?php echo r4me_get_directory_url(); ?>">&laquo; Back to the vendors list</a>
				<div class="pad20"></div>
				<div class="single-vendor-disclosure">
					<div class="well well-sm">The information on this page was manually gathered using publicly available information and is presented as-is for informational and research purposes only. Route4Me's internal team of analysts used all reasonable efforts to represent the information as accurately as possible to identify how industry leading telematics organizations are evolving. If you believe that the information on this website is incorrect, please email <a href='mailto:support@route4me.com'>support@route4me.com</a> with supporting documentation so that we may resolve the discrepancy.</div>
				</div>
			</div>
</div>
<?php	endwhile;
	else:
		echo "The vendor doesn't exist";
	endif;
	
} ?>


<div class="pad20"></div>

<?php include_once('footer.php'); ?>