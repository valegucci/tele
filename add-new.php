<?php 
require_once('functions.php');

if(!r4me_user_logged_in()){
  header('Location: ' . r4me_get_directory_url() . '/login.php');
  exit();
}
?>

<?php include_once('header.php'); ?>

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


  $file_name = '';
  if(empty($errors)){
    if (isset($_FILES['vendorLogo']) && is_uploaded_file($_FILES['vendorLogo']['tmp_name'])) {
        $target_dir = "logos/";
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
    }else{
      $errors[] = "You should choose a logo!";
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
      $logo_url = r4me_get_directory_url() . '/' . $file_dir;
      $logo_url = mysqli_real_escape_string($mysqli, $logo_url);


      $sql = "INSERT INTO r4me_vendors (name, description, slug, logo_url, website_url, api_docs_url, is_integrated, size) 
      VALUES ('$title', '$desc', '$slug', '$logo_url', '$url', '$docs', '$vendor_integrated', '$vendor_size')";
      $result = $mysqli->query($sql);
      if($result){
        $vendor_id = $mysqli->insert_id;
        
        if(!empty($vendor_countries)){
          foreach ($vendor_countries as $country) {
            $mysqli->query("INSERT INTO r4me_vendor_country_relationship (vendor_id, country_id) VALUES ('$vendor_id', '$country')");
          }
        }
        if(!empty($vendor_features)){
          foreach ($vendor_features as $feature) {
            $mysqli->query("INSERT INTO r4me_vendor_feature_relationship (vendor_id, feature_id) VALUES ('$vendor_id', '$feature')");
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
            <form name="addNewForm" method="POST" id="addNewForm" action="" enctype="multipart/form-data">
               <div class="form-group">
                  <label for="vendorTitle">Vendor Title <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="vendorTitle" name="vendorTitle" value="<?php echo (isset($_POST['vendorTitle']) ? htmlentities($_POST['vendorTitle']) : ''); ?>">
               </div>
               <div class="form-group">
                  <label for="vendorWebsite">Vendor Website</label>
                  <input type="text" class="form-control" id="vendorWebsite" name="vendorWebsite" value="<?php echo (isset($_POST['vendorWebsite']) ? htmlentities($_POST['vendorWebsite']) : ''); ?>">
               </div>
               <div class="form-group">
                  <label for="vendorAPIDocs">Vendor API Docs URL</label>
                  <input type="text" class="form-control" id="vendorAPIDocs" name="vendorAPIDocs" value="<?php echo (isset($_POST['vendorAPIDocs']) ? htmlentities($_POST['vendorAPIDocs']) : ''); ?>">
               </div>
               <div class="form-group">
                  <label for="vendorDescription">Vendor Description</label>
                  <textarea class="form-control" id="vendorDescription" name="vendorDescription"><?php echo (isset($_POST['vendorAPIDocs']) ? htmlentities($_POST['vendorAPIDocs']) : ''); ?></textarea>
               </div>
               <div class="form-group">
                  <label for="vendorIntegrated">Vendor Integrated</label>
                  <select class="form-control" id="vendorIntegrated" name="vendorIntegrated"> 
                    <option value="yes">Yes</option>
                    <option value="now" <?php echo (isset($_POST['is_integrated']) && $_POST['is_integrated'] !== "1") ? 'selected' : '';?>>No</option>
                  </select>
               </div>
               <div class="form-group">
                  <label for="vendorSize">Vendor Size</label>
                  <select class="form-control" id="vendorSize" name="vendorSize">
                    <option value="global">Global</option>
                    <option value="regional">Regional</option>
                    <option value="local">Local</option>
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
                        <option value="<?php echo $country['id']; ?>"><?php echo $country['name']; ?></option>
                    <?php endforeach; ?>
                  </select>
               </div>
               <div class="form-group">
                  <label for="vendorLogo">Vendor Logo <span class="text-danger">*</span></label>
                  <input type="file" id="vendorLogo" name="vendorLogo">
               </div>
               <div class="pad10"></div>
               <input type="hidden" id="r4me_submitted" name="r4me_submitted" value="submitted">
               <button type="submit" class="btn btn-primary btn-default" id="r4me_vendor_submit">Submit</button>
            </form>
         </div>
<div class="pad50"></div>

<?php include_once('footer.php'); ?>