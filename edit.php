<?php 
require_once('functions.php');

if(!r4me_user_logged_in()){
  header('Location: ' . r4me_get_directory_url() . '/login.php');
  exit();
}
if(!isset($_GET['id'])){
  header('Location: ' . r4me_get_directory_url() . '/admin.php');
  exit();
}
if(!ctype_digit($_GET['id'])){
  header('Location: ' . r4me_get_directory_url() . '/admin.php');
  exit();
} 

include_once('header.php');

$vendor = $_GET['id'];

$vendorFeatures = r4me_get_vendor_feature($vendor);
$vendorCountries = r4me_get_vendor_country($vendor);

$query = new R4ME_Query(array('id'=>$vendor));
if($query->has_vendors()):
while ($row = $query->get_vendors()): ?>

<div class="r4me-form-top"></div>

<div class="r4me-form-container container">
    <div id="r4me_add_new_vendor_response">
<?php 

$vendor_title = $vendor_size = $vendor_website = $vendor_api_docs = $vendor_desc = '';
$vendor_features = $vendor_countries = array();

  if(isset($_POST['r4me_submitted'])){
    $errors = array();

    if(isset($_POST['vendorTitle'])){
      $vendor_title = $_POST['vendorTitle'];
      if(trim($vendor_title) === ''){
        $errors[] = 'Empty title!';
      }
    }else{
      $errors[] = "Title isn't set!";
    }

    if(isset($_POST['vendorSize'])){
      $vendor_size = $_POST['vendorSize'];
      if($vendor_size !== 'global' && $vendor_size !== 'regional' && $vendor_size !== 'local'){
        $errors[] = 'Undefined Vendor size!';
      }
    }else{
      $errors[] = 'Undefined Vendor size!';
    }

    $vendor_integrated = 0;
    if(isset($_POST['vendorIntegrated']) && $_POST['vendorIntegrated'] === 'yes'){
      $vendor_integrated = 1;
    }

    if(isset($_POST['vendorWebsite'])){
      $vendor_website = $_POST['vendorWebsite'];
      if (trim($vendor_website) !== '' && !filter_var($vendor_website, FILTER_VALIDATE_URL)) { 
        $errors[] = "Vendor website isn't a URL!";
      }
    }

    if(isset($_POST['vendorAPIDocs'])){
      $vendor_api_docs = $_POST['vendorAPIDocs'];
      if (trim($vendor_api_docs) !== '' && !filter_var($vendor_api_docs, FILTER_VALIDATE_URL)) { 
        $errors[] = "Vendor website isn't a URL!";
      }
    }

    if(isset($_POST['vendorDescription'])){
      $vendor_desc = $_POST['vendorDescription'];
    }

    if(isset($_POST['vendorFeatures'])){
      $vendor_features = $_POST['vendorFeatures'];
      r4me_delete_feature_relations($vendor);
      if (is_array($vendor_features)) {
        foreach ($vendor_features as $value) {
          if(!(is_numeric($value))){
            $errors[] = "Features IDs aren't numeric!";
            break;
          }
        }
      }else{
        $errors[] = "Features array is empty!";
      } 
    }

    if(isset($_POST['vendorCountries'])){
      $vendor_countries = $_POST['vendorCountries']; 
      r4me_delete_country_relations($vendor);
      if (is_array($vendor_countries)) {
        foreach ($vendor_countries as $value) {
          if(!(is_numeric($value))){
            $errors[] = "Country IDs aren't numeric!";
            break;
          }
        }
      }else{
        $errors[] = "Countries array is empty!";
      } 
    }


  $file_dir = '';
  if(empty($errors)){
    if (isset($_FILES['vendorLogo']) && $_FILES['vendorLogo']['size'] > 0 ) {
        $target_dir = "logos/";
        $prev_logo = basename($row['logo_url']);
        if(file_exists($target_dir . $prev_logo)) unlink($target_dir . $prev_logo);
        $name = basename($_FILES['vendorLogo']['name']);
        $target_file = $target_dir . $name;
        $tmp_name = $_FILES['vendorLogo']['tmp_name'];
        $error    = $_FILES['vendorLogo']['error'];
        if ($error === UPLOAD_ERR_OK) {
          $extension = pathinfo($name, PATHINFO_EXTENSION);
          $uniqe_name = $target_dir . uniqid(r4me_slug_encode($vendor_title), true) . '.' . $extension;
          if ($extension != 'jpg' && $extension != 'png' && $extension != 'gif') {
            $errors[] = "Invalid file type uploaded.";
          }else {
            if (move_uploaded_file($tmp_name, $uniqe_name)) {
              $file_dir = $uniqe_name;
            }else {
              $errors[] = "Sorry, there was an error uploading your file.";
            }    
          }  
        }
    }
  }


    if(!empty($errors)){
      foreach ($errors as $key => $error) {
        echo '<div class="alert alert-danger" role="alert"><strong>Error!</strong> '. $error .'</div>';
      }
    }else{
      $db = Database::getInstance();
      $mysqli = $db->getConnection(); 

      $title = mysqli_real_escape_string($mysqli, $vendor_title);
      $slug = r4me_slug_encode($title);
      $desc = mysqli_real_escape_string($mysqli, $vendor_desc);
      $url = mysqli_real_escape_string($mysqli, $vendor_website);
      $docs = mysqli_real_escape_string($mysqli, $vendor_api_docs);
      
      if($file_dir !== ''){
        $logo_url = r4me_get_directory_url() . '/' . $file_dir;
        $logo_url = mysqli_real_escape_string($mysqli, $logo_url);
    $sql = "UPDATE r4me_vendors SET name='$title', description='$desc', slug='$slug', logo_url='$logo_url', website_url='$url', api_docs_url='$docs', is_integrated='$vendor_integrated', size='$vendor_size' WHERE id='$vendor'";
      }else{
        $sql = "UPDATE r4me_vendors SET name='$title', description='$desc', slug='$slug', website_url='$url', api_docs_url='$docs', is_integrated='$vendor_integrated', size='$vendor_size' WHERE id='$vendor'";
      }

      $result = $mysqli->query($sql);
      if($result){
        
        if(!empty($vendor_countries)){
          foreach ($vendor_countries as $country) {
            $mysqli->query("INSERT INTO r4me_vendor_country_relationship (vendor_id, country_id) VALUES ('$vendor', '$country')");
          }
        }
        if(!empty($vendor_features)){
          foreach ($vendor_features as $feature) {
            $mysqli->query("INSERT INTO r4me_vendor_feature_relationship (vendor_id, feature_id) VALUES ('$vendor', '$feature')");
          }
        }
        echo  '<div class="alert alert-success" role="alert"><strong>Congrats!</strong> Vendor successfully created!</div>';
      }else{
        echo  '<div class="alert alert-danger" role="alert"><strong>Error!</strong> '. $mysqli->error .'</div>';
      } 
    }

  }

?>
    </div>
  <form name="editForm" method="POST" id="editForm" action="" enctype="multipart/form-data">
        <div class="form-group">
            <label for="vendorTitle">Vendor Title <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="vendorTitle" name="vendorTitle" value="<?php echo htmlentities($row['name'], ENT_COMPAT) ?>">
        </div>
        <div class="form-group">
            <label for="vendorWebsite">Vendor Website</label>
            <input type="text" class="form-control" id="vendorWebsite" name="vendorWebsite" value="<?php echo htmlentities($row['website_url'], ENT_COMPAT) ?>">
        </div>
        <div class="form-group">
            <label for="vendorAPIDocs">Vendor API Docs URL</label>
            <input type="text" class="form-control" id="vendorAPIDocs" name="vendorAPIDocs" value="<?php echo htmlentities($row['api_docs_url'], ENT_COMPAT) ?>">
        </div>
        <div class="form-group">
            <label for="vendorDescription">Vendor Description</label>
            <textarea class="form-control" id="vendorDescription" name="vendorDescription"><?php echo htmlentities($row['description']) ?></textarea>
        </div>
        <div class="form-group">
            <label for="vendorIntegrated">Vendor Integrated</label>
            <select class="form-control" id="vendorIntegrated" name="vendorIntegrated"> 
                <option value="yes">Yes</option>
                <option value="now" <?php echo ($row['is_integrated'] !== "1") ? 'selected' : '';?>>No</option>
            </select>
        </div>
        <div class="form-group">
            <label for="vendorSize">Vendor Size</label>
            <select class="form-control" id="vendorSize" name="vendorSize">
                <option value="global" <?php echo ($row['size'] === "global") ? 'selected' : '';?>>Global</option>
                <option value="regional" <?php echo ($row['size'] === "regional") ? 'selected' : '';?>>Regional</option>
                <option value="local" <?php echo ($row['size'] === "local") ? 'selected' : '';?>>Local</option>
            </select>
        </div>
        <div class="form-group">
            <label for="vendorFeatures">Features</label>
            <select class="vendorFeaturesSelect" data-placeholder="Choose a feature..." multiple id="vendorFeatures" name="vendorFeatures[]">
                <?php 

                $features = r4me_get_features(); 
                $grarr = array();
                
                foreach ($features as $feature): 
                  if(!in_array($feature['group'], $grarr)){
                    echo (sizeof($grarr) > 1 ? '</optgroup>' : '');
                    echo '<optgroup label="'. $feature['group'] . '">'; 
                    
                    $grarr[] = $feature['group'];
                  }

                  echo '<option value="'. $feature['id'] .'" '. (r4me_search_array($feature['slug'], $vendorFeatures) ? 'selected' : '') .'>'. $feature['name'] .'</option>';
                endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="vendorCountries">Countries</label>
            <select class="vendorCountriesSelect" multiple data-placeholder="Choose a country..." id="vendorCountries" name="vendorCountries[]">
                <?php $countries = r4me_get_countries(); 
                foreach ($countries as $country): ?>
                <option value="<?php echo $country['id']; ?>" <?php echo (r4me_search_array($country['name'], $vendorCountries) ? 'selected' : ''); ?>><?php echo $country['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
          <label for="vendorLogo">Vendor Logo</label>
          <div class="left"><img src="<?php echo htmlentities($row['logo_url']); ?>" width="160" height="90"></div>
            <label for="vendorLogo">Upload New Logo</label>
            <input type="file" id="vendorLogo" name="vendorLogo">
        </div>
        <div class="pad10"></div>
        <input type="hidden" id="r4me_submitted" name="r4me_submitted" value="submitted">
        <button type="submit" class="btn btn-primary btn-default" id="r4me_vendor_submit">Submit</button>
    </form> 
</div>   

<?php endwhile; endif; ?>

<div class="pad50"></div>

<?php include_once('footer.php'); ?>