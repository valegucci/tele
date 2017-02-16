<?php 
require_once (dirname(__FILE__).'/functions.php');
$countries = r4me_get_countries(); 
$telematic_features = r4me_get_features();
$integratedUrl = r4me_get_url_currently(array('is_integrated'));
$countryUrl = r4me_get_url_currently(array('country'));
$sizeUrl = r4me_get_url_currently(array('size'));
$featureUrl = r4me_get_url_currently(array('feature'));
?>
<div class="widget widget-search">
	<h5>Filter By Name</h5>
	<form action="" method="get">
		<input name="s" id="s" class="form-control search-query" type="text" value="" placeholder="search..." />
		<button class="search-btn" type="submit"><i class="glyphicon glyphicon-search"></i></button>
	</form>
</div>
<div class="widget widget-integrated">
	<h5>Integrated with Route4Me</h5>
	<ul>  
		<li><a href="<?php echo $integratedUrl; ?>" class="<?php echo (isset($_GET['is_integrated']) ? '' : 'active'); ?>">All</a></li>
		<li><a href="<?php echo $integratedUrl . (strpos($integratedUrl, '?') ? '&' : '?') .'is_integrated=1'; ?>" class="<?php echo (isset($_GET['is_integrated']) && $_GET['is_integrated'] === '1' ? 'active' : ''); ?>">Integrated with Route4Me</a></li>
	</ul>
</div>
<div class="widget widget-country">
	<div class="widget-inner">
	<h5>Country</h5>
	<ul>
		<li><a href="<?php echo $countryUrl; ?>" class="<?php echo (isset($_GET['country']) ? '' : 'active'); ?>">All</a></li>
		<?php foreach ($countries as $country):
			if(!r4me_country_has_vendor($country['id'])) continue; ?>
			<li><a href="<?php echo $countryUrl . (strpos($countryUrl, '?') ? '&' : '?') .'country='.$country['code']; ?>" class="<?php echo (isset($_GET['country']) && $_GET['country'] === $country['code'] ? 'active' : ''); ?>"><?php echo $country['name']; ?></a></li>
		<?php endforeach; ?>
	</ul>
	</div>
</div>
<div class="widget widget-company-size">
	<h5>Company Size</h5>
	<ul>
		<li><a href="<?php echo $sizeUrl; ?>" class="<?php echo (isset($_GET['size']) ? '' : 'active'); ?>">All</a></li>
		<li><a href="<?php echo $sizeUrl . (strpos($sizeUrl, '?') ? '&' : '?') .'size=global'; ?>" class="<?php echo (isset($_GET['size']) && $_GET['size'] === 'global' ? 'active' : ''); ?>">Global</a></li>
		<li><a href="<?php echo $sizeUrl . (strpos($sizeUrl, '?') ? '&' : '?') .'size=regional'; ?>" class="<?php echo (isset($_GET['size']) && $_GET['size'] === 'regional' ? 'active' : ''); ?>">Regional</a></li>
		<li><a href="<?php echo $sizeUrl . (strpos($sizeUrl, '?') ? '&' : '?') .'size=local'; ?>" class="<?php echo (isset($_GET['size']) && $_GET['size'] === 'local' ? 'active' : ''); ?>">Local</a></li>
	</ul>
</div>
<div class="widget widget-telematic-features">
	<h5>Telematic Features</h5>
	<ul>
		<li><a href="<?php echo $featureUrl; ?>" class="<?php echo (isset($_GET['feature']) ? '' : 'active'); ?>">All</a></li>
		<?php $arr = array(); ?>
		<?php foreach ($telematic_features as $feature): 
			if(!in_array($feature['group'], $arr)){
			 echo '<li class="feature-group-name">' . $feature['group'] . '</li>'; 
			 $arr[] = $feature['group'];
			}
		?>
			<li><a href="<?php echo $featureUrl . (strpos($featureUrl, '?') ? '&' : '?') .'feature='.$feature['slug']; ?>" class="<?php echo (isset($_GET['feature']) && $_GET['feature'] === $feature['slug'] ? 'active' : ''); ?>"><?php echo $feature['name']; ?></a></li>
		<?php endforeach; ?>
	</ul>
</div>