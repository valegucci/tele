<?php 
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
  $country = r4me_param_decode($_GET['country']);
  if(!in_array($country, $countries)){
    $country = '';
  }
}

if(isset($_GET['feature'])){
  $features = r4me_get_features();
  $feature = r4me_param_decode($_GET['feature']);
  if(!in_array($feature, $features)){
    $feature = '';
  }
}

if(isset($_GET['s'])){
  $s = r4me_param_encode($_GET['s']);
}

$args = array(
  'size' => $size,
  'feature' => $feature,
  'is_integrated' => $integrated,
  'search' => $s,
  'country' => $country,
  'feature' => $feature
  );

$total_after_query = new R4Me_Query($args, 'COUNT');
$total_after_query = $total_after_query->count_vendors();
$per_page = VENDORS_PER_PAGE;
$total_pages = ceil($total_after_query / $per_page);

$pageURL = r4me_get_url_currently(array('page')); 
if($total_pages > 1 ):
?>

<div class="clearfix pad20"></div>
<div class="r4me-pagination">
<?php if (!isset($_GET['page']) && $total_pages > 1): ?>
	<a href="<?php echo $pageURL . (strpos($pageURL, '?') ? '&' : '?') .'page=2'; ?>" class="next-page hidden" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
<?php endif; ?>
</div>

<?php endif; ?>